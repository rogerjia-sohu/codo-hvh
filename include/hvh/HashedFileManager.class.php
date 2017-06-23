<?php
namespace hvh {

require_once 'hvh/hvh.class.php';

const HASH_MD5 = 0;
const HASH_SHA1 = 1;

class HashedFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	// all hashed files will be placed under D:/Server001/BaseDir/
	protected $mRootPath; // D:/Server001
	protected $mBasePath; // BaseDir
	protected $mHashFunc;
	protected $mDirNameLength;
	protected $mDBTableName;
	protected static $mHashFuncArray = [
		HASH_MD5 => 'md5_file',
		HASH_SHA1 => 'sha1_file'
	];
	protected static $mDisabledSuffix = '-disabled';

	protected $mHashedKey;
	protected $mExt;
	protected $mSqlColBegin;
	protected $mSqlCols;
	protected $mSqlColEnd;

	protected $mSqlValBegin;
	protected $mSqlVals;
	protected $mSqlValEnd;

	protected function dlfile($file_url, $save_to) {
		$bufsize = 8192;
		$in = fopen($file_url, "rb");
		$out = fopen($save_to, "wb");
		while ($chunk = fread($in, $bufsize)) {
			fwrite($out, $chunk, $bufsize);
		}
		fclose($in);
		fclose($out);
		return filesize($save_to);
	}

	public function __construct($pRootPath, $pBasePath, $pHashFunc, $pDirNameLength = 2, $pDBTableName = null) {
		$this->mRootPath = $pRootPath;
		$this->mBasePath = $pBasePath;
		if ($pHashFunc < 0 || $pHashFunc > 1) {
			$pHashFunc = HASH_MD5;
		}
		$this->mHashFunc = $pHashFunc;
		
		if ($this->mHashFunc === HASH_MD5) {
			if ($pDirNameLength < 1 || $pDirNameLength > (strlen(md5('a')) / 8)) {
				$pDirNameLength = 2;
			}
		} else {
			if ($pDirNameLength < 1 || $pDirNameLength > (strlen(sha1('a')) / 10)) {
				$pDirNameLength = 2;
			}
		}
		$this->mDirNameLength = $pDirNameLength;
		$this->mDBTableName = $pDBTableName;
	}

	public function Exists($pFilePath) {
		return file_exists($this->GetHashedFileName($pFilePath));
	}

	public function SaveFile($pFilePath, $pForceExt = null, $pRewrittenURL = true, &$pHashedKey = null, $pUserID = null) {
		if (empty($pForceExt)) {
			$this->mExt = pathinfo($pFilePath, PATHINFO_EXTENSION);
		} else {
			$this->mExt = $pForceExt;
		}

		$this->mHashedKey = $this->GetHashedFileName($pFilePath);
		if (empty($this->mHashedKey)) {
			return false;
		}
		if (isset($pHashedKey)) {
			$pHashedKey = $this->mHashedKey;
		}

		if (empty($this->mExt)) {
			$hashedfilepath = sprintf('%s/%s/%s',$this->mRootPath, $this->mBasePath,
						implode('/', str_split($this->mHashedKey, $this->mDirNameLength)));
		} else {
			$hashedfilepath = sprintf('%s/%s/%s.%s',$this->mRootPath, $this->mBasePath,
						implode('/', str_split($this->mHashedKey, $this->mDirNameLength)),$this->mExt);
		}
		$dirname = dirname($hashedfilepath);

		if (!file_exists($dirname)) {
			mkdir($dirname, 0777, true);
		}
		if (!file_exists($hashedfilepath)) {
			$disabledfile = $hashedfilepath . self::$mDisabledSuffix;
			if (file_exists($disabledfile)) {
				$ret = rename($disabledfile, $hashedfilepath);
			} else {
				$ret = $this->dlfile($pFilePath, $hashedfilepath);
			}
		} else {
			$ret = true;
		}

		$this->StoreToDB($pUserID);

		return ($ret ?
					$pRewrittenURL?
						$this->ConvertToUrl(sprintf('%s/%s/%s.%s',
											$this->mRootPath, $this->mBasePath,
											$this->mHashedKey, $this->mExt))
						: $this->ConvertToUrl($hashedfilepath)
					: false);
	}

	public function RemoveFile($pFileHashCode) {
		$sql = sprintf('select `ReferenceCount`,`Ext` from `%s` where `ID`="%s" and `Status`=1',
						$this->mDBTableName, $pFileHashCode);
		$db = Lib::DBInit();
		$result = $db->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		if (!is_array($row)) {
			return false;
		}

		$cnt = $row[0];
		$ext = $row[1];
		if ($cnt > 0) {
			$ret = $this->UpdateReferenceCnt($pFileHashCode, -1, $ext);
		}

		return $ret;
	}

	public function GetHashedFileName($pFilePath) {
		$func = self::$mHashFuncArray[$mHashFunc % count(self::$mHashFuncArray)];
		return $func($pFilePath);
	}

	public function GetOneLocalFileUrl($pID) {
		$sql = sprintf("select Ext from `%s` where `ID`='%s' and `Status`=1", $this->mDBTableName, $pID);
		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);
		$ext = $result->fetch_array(MYSQLI_NUM)[0];
		
		return empty($ext)?
				false
				: sprintf('http://%s/%s/%s.%s',	$_SERVER['HTTP_HOST'], $this->mBasePath, $pID, $ext);
	}

	public function RealFilePath($pID) {
		$ret = false;

		$sql = sprintf("select Ext from `%s` where `ID`='%s' and `Status`=1", $this->mDBTableName, $pID);
		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);
		$ext = $result->fetch_array(MYSQLI_NUM)[0];

		if (!empty($ext)) {
			$rpath = implode('/', str_split($pID, $this->mDirNameLength));
			$ret = sprintf('%s/%s/%s.%s',
						$this->mRootPath, $this->mBasePath, $rpath, $ext);
		}

		return $ret;
	}

	protected function ConvertToUrl($pHashedFileName) {
		$ret = sprintf('http://%s%s', $_SERVER['HTTP_HOST'],
			substr($pHashedFileName, strlen($this->mRootPath)));
		return $ret;
	}

	protected function UpdateReferenceCnt($pID, $pIncVal, $pExt = null) {
		$sql = sprintf('update `%s` set ReferenceCount=ReferenceCount + %d where `ID`="%s";',
						$this->mDBTableName, (int)$pIncVal, $pID);

		$db = Lib::DBInit();
		$db->begin_transaction();
			$db->query($sql);
			if ((int)$pIncVal > 0) {
				$sql = sprintf('update `%s` set `Status`=1 where `ID`="%s" and `Status`=0;',
								$this->mDBTableName, $pID);
			} else  {
				$sql = sprintf('update `%s` set `Status`=0 where `ID`="%s" and `ReferenceCount`=0;',
								$this->mDBTableName, $pID);
				$this->DeleteFile($pID, $pExt);
			}
			$db->query($sql);
		$ret = $db->commit();
		Lib::DBTerm($db);
		return $ret;
	}

	protected function DeleteFile($pFileHashCode, $pExt, $pDisableOnly = true) {
		$filepath = sprintf('%s/%s/%s.%s',
						$this->mRootPath, $this->mBasePath,
						implode('/', str_split($pFileHashCode, $this->mDirNameLength)),
						$pExt);
		//var_dump($filepath);
		if ($pDisableOnly) {
			// RENAMING
			$ret = rename($filepath, $filepath . self::$mDisabledSuffix);
		} else {
			// DELETING
			$ret = unlink($filepath);
		}
		return $ret;
	}

	protected function StoreToDB($pUserID = null) {
		if (empty($this->mDBTableName)) {
			return false;
		}

		$this->CreateTableIfNotExists();

		$this->mSqlColBegin = 'insert into `'.$this->mDBTableName.'`(';
		$this->mSqlColEnd = ') ';
		$this->mSqlValBegin = 'values(';
		$this->mSqlValEnd = ');';
		
		$this->SetColVal(array('ID' => "'$this->mHashedKey'",
								'Ext' => "'$this->mExt'",
								'ReferenceCount' => 1,
								'CreatedBy' => ($pUserID? "'$pUserID'" : '\'0000\''))
						);
		$sql = sprintf('%s %s %s %s %s %s',
					$this->mSqlColBegin, $this->mSqlCols, $this->mSqlColEnd,
					$this->mSqlValBegin, $this->mSqlVals, $this->mSqlValEnd);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		$errno = $db->errno;
		Lib::DBTerm($db);

		if ($db->errno === 1062) {
			// a record is already existed
			$this->UpdateReferenceCnt($this->mHashedKey, 1);
		}
	}

	protected function SetColVal($pColValArray, $pAppend = false) {
		if (!is_array($pColValArray)) {
			return false;
		}

		$colarray = array_keys($pColValArray);
		$valarray = array_values($pColValArray);
		if (count($colarray) !== count($valarray)) {
			return false;
		}

		$cols = implode(',', $colarray);
		$vals = implode(',', $valarray);

		if ($pAppend) {
			$this->mSqlCols .= ',' . $cols;
			$this->mSqlVals .= ',' . $vals;
		} else {
			$this->mSqlCols = $cols;
			$this->mSqlVals = $vals;
		}

		return true;
	}
	
	protected function CreateTableIfNotExists() {
		$tblname = $this->mDBTableName;
		if (DBUtils::TableExists($tblname)) {
			return;
		}

		$sql =
"
CREATE TABLE `$tblname` (
  `ID` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT '文件的hash(md5 | sha1)码',
  `Ext` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT '扩展名',
  `ReferenceCount` int(10) NOT NULL COMMENT '引用计数',
  `CreateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";
		$db = Lib::DBInit();
		$db->query($sql);
		Lib::DBTerm($db);
	}
}
}// End of namespace
?>