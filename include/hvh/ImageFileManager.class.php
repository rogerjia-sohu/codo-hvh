<?php
namespace hvh {

require_once 'hvh/HashedFileManager.class.php';

class ImageFileManager extends HashedFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct($pRoot = '', $pBasePath = '', $pHashFunc = HASH_MD5,
								$pDirNameLength = 2, $pDBTableName = null) {
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
		parent::__construct($pRoot, $pBasePath, $pHashFunc, $pDirNameLength, $pDBTableName);
	}
}
}// End of namespace
?>
