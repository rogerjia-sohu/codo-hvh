<?php
namespace hvh {

require_once 'hvh/hvh.class.php';

class Silk2AmrFileManager extends HashedFileManager {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected static $mEngine; // Lib::$Config->Silk2Amr->Engine;
	
	public function __construct() {
		$root = $_SERVER[Lib::$Config->Silk2Amr->FileManager->Root];
		$basepath = Lib::$Config->Silk2Amr->FileManager->BaseDir;
		$hashfunc = Lib::$Config->Silk2Amr->FileManager->HashFunc;
		$dirnamelength = Lib::$Config->Silk2Amr->FileManager->DirNameLength;
		$dbtablename = Lib::$Config->Silk2Amr->FileManager->DBTableName;
		parent::__construct($root, $basepath, $hashfunc, $dirnamelength, $dbtablename);

		self::$mEngine = Lib::$Config->Silk2Amr->Engine;
	}
	
	public function ToAmr($pSilkFile) {
		if (!file_exists($pSilkFile)) {
			return false;
		}

		// Decodes silk to pcm
		$cmdline = self::$mEngine->SilkDecoder->Bin . ' '
					. sprintf(self::$mEngine->SilkDecoder->ParamFmtList1, $pSilkFile, $pSilkFile);
		system($cmdline);

		// Coverts pcm to wav
		$cmdline = self::$mEngine->ffmpeg->Bin . ' '
					. sprintf(self::$mEngine->ffmpeg->ParamFmtList1, $pSilkFile, $pSilkFile);
		system($cmdline);

		// Encodes wav to amr
		$amrfile = str_replace('.silk', '.amr', $pSilkFile);
		$cmdline = self::$mEngine->ffmpeg->Bin . ' '
					. sprintf(self::$mEngine->ffmpeg->ParamFmtList2, $pSilkFile, $amrfile);
		system($cmdline);

		// Cleans up
		unlink("$pSilkFile.pcm");
		unlink("$pSilkFile.wav");
		return true;
	}
}
}// End of namespace
?>