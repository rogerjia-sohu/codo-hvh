<?php
namespace hvh {

require_once 'hvh/HashedFileManager.class.php';
require_once 'hvh/ImageFileManager.class.php';

abstract class EasemobFileManager extends HashedFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct($pCfgManager) {
		if (!is_object($pCfgManager)) {
			return;
		}

		$root = $_SERVER[$pCfgManager->Root];
		$basepath = $pCfgManager->BaseDir;
		$hashfunc = $pCfgManager->HashFunc;
		$dirnamelength = $pCfgManager->DirNameLength;
		$dbtablename = $pCfgManager->DBTableName;

		parent::__construct($root, $basepath, $hashfunc, $dirnamelength, $dbtablename);
	}
}

class EasemobImageFileManager extends ImageFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct($pCfgManager) {
		if (!is_object($pCfgManager)) {
			return;
		}

		$root = $_SERVER[$pCfgManager->Root];
		$basepath = $pCfgManager->BaseDir;
		$hashfunc = $pCfgManager->HashFunc;
		$dirnamelength = $pCfgManager->DirNameLength;
		$dbtablename = $pCfgManager->DBTableName;

		$compression = $pCfgManager->Compression;

		parent::__construct($root, $basepath, $hashfunc, $dirnamelength, $dbtablename, $compression);
	}
}

class EasemobImageFileManager_OLD extends EasemobFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct() {
		parent::__construct(Lib::$Config->Easemob->ImageFileManager);
	}
}

class EasemobAudioFileManager extends EasemobFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct() {
		parent::__construct(Lib::$Config->Easemob->AudioFileManager);
	}
}

class EasemobVideoFileManager extends EasemobFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct() {
		parent::__construct(Lib::$Config->Easemob->VideoFileManager);
	}
}

class EasemobOtherFileManager extends EasemobFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct() {
		parent::__construct(Lib::$Config->Easemob->OtherFileManager);
	}
}
}// End of namespace
?>
