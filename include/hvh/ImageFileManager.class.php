<?php
namespace hvh {

class ImageFileManager extends HashedFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected $mCompression;

	public function __construct($pRoot = '', $pBasePath = '', $pHashFunc = HASH_MD5,
								$pDirNameLength = 2, $pDBTableName = null, $pCompression = null) {
		if (empty($pRoot)) {
			$pRoot = $_SERVER[Lib::$Config->ImageFileManager->Root];
		}
		if (empty($pBasePath)) {
			$pBasePath = Lib::$Config->ImageFileManager->BaseDir;
		}
		if ($pHashFunc < 0 || $pHashFunc > 1) {
			$pHashFunc = Lib::$Config->ImageFileManager->HashFunc;
		}
		if ($pDirNameLength < 1 || $pDirNameLength > 4) {
			$pDirNameLength = Lib::$Config->ImageFileManager->DirNameLength;
		}

		if (empty($pDBTableName)) {
			$pDBTableName = Lib::$Config->ImageFileManager->DBTableName;
		}

		if (!empty($pCompression)) {
			$this->mCompression = Lib::$Config->ImageFileManager->Compression;
		} else {
			$this->mCompression = null;
		}

		parent::__construct($pRoot, $pBasePath, $pHashFunc, $pDirNameLength, $pDBTableName);
	}

	public function EnableCompression($pOnOff) {
		if ($this->mCompression) {
			$this->mCompression->Enabled = (int)(bool)$pOnOff;
			return true;
		}
		return false;
	}

	public function SetCompressionMode($pCfgName) {
		if ($this->mCompression && property_exists($this->mCompression, $pCfgName)) {
			$this->mCompression->Use = $pCfgName;
			return true;
		}
		return false;
	}

	public function SaveFile($pFilePath, $pForceExt = null, $pRewrittenURL = true, &$pHashedKey = null, $pUserID = null) {
		if ($this->mCompression && $this->mCompression->Enabled) {
			$cfg = $this->mCompression->Use;
			$mode = $this->mCompression->$cfg;
			$compressor = new ImageCompressor($pFilePath, $mode);
			$filelist = $compressor->CompressTo($pFilePath);
		} else {
			$filelist = array($pFilePath);
		}

		$dstlist = array();
		foreach ($filelist as $file) {
			$dstfile = parent::SaveFile($file, $pForceExt, $pRewrittenURL, $pHashedKey, $pUserID);
			array_push($dstlist, $dstfile);
			if (file_exists($file)) {
				unlink($file);
			}
		}
		return $dstlist;
	}
}
}// End of namespace
?>
