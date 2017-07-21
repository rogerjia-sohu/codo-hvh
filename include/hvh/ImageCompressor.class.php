<?php
namespace hvh {

const COPY_RESIZED = 0;
const COPY_RESAMPLED = 1;

class ImageCompressor{

	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected static $mCopyFuncArray = [
		COPY_RESIZED => 'imagecopyresized',
		COPY_RESAMPLED => 'imagecopyresampled'
	];

	protected $mSrcFile;
	protected $mFileSize;
	protected $mImgWidth;
	protected $mImgHeight;

	protected $mDefaultPercent;
	protected $mDefaultQuality;
	protected $mDefaultFilters;
	protected $mKeepOriginal;

	protected $mMimeType;
	protected $mIsValidSrcImg = false;

	public function __construct($pSrcFile, $pMode = null, $pDefaultPercent = 0.75, $pDefaultQuality = 0.75, $pDefaultFilters = 0) {
		$this->mSrcFile = $pSrcFile;
		$this->mFileSize = @filesize($pSrcFile);
		
		if (self::IsValidPercent($pDefaultPercent)) {
			$this->mDefaultPercent = $pDefaultPercent;
		} else {
			$this->mDefaultPercent = 0.75;
		}

		if (self::IsValidQuality($pDefaultQuality)) {
			$this->mDefaultQuality = $pDefaultQuality;
			
		} else {
			$this->mDefaultQuality = 0.75;
		}

		if (self::IsValidFilters($pDefaultFilters)) {
			$this->mDefaultFilters = $pDefaultFilters;
		} else {
			$this->mDefaultFilters = 0;
		}

		$imginfo = @getimagesize($pSrcFile);
		if (!empty($imginfo)) {
			list($this->mImgWidth, $this->mImgHeight) = $imginfo;
			$this->mMimeType = $imginfo['mime'];
			$this->mIsValidSrcImg = true;
			$this->mKeepOriginal = true;

			if ($pMode) {
				if (property_exists($pMode, 'Percent')) {
					$percent = $pMode->Percent;
				} else if (property_exists($pMode, 'MaxSide')) {
					$side = max($this->mImgWidth, $this->mImgHeight);
					if ($side > $pMode->MaxSide) {
						$percent = $pMode->MaxSide / $side;
					} else {
						$percent = 1.0;
					}
				}
				$quality = $pMode->Quality;
				$filters = $pMode->Filters;
				$this->mKeepOriginal = (bool)$pMode->KeepOriginal;
				$this->mOriginalPrefix = $pMode->OriginalPrefix;
				$this->mDefaultPercent = $percent;
				$this->mDefaultQuality = $quality;
				$this->mDefaultFilters = $filters;
			}
		} else {
			// Invalid srcfile
		}
	}

	public function CompressTo($pDstFile, $pResampled = true, $pUserPercent = null, $pUserQuality = null, $pUserFilters = null) {
		$CompressionFunc = self::$mCopyFuncArray[((int)(bool)$pResampled)];
		if (!$this->mIsValidSrcImg) {
			return false;
		}

		if ($this->mKeepOriginal) {
			list($dirname, $fname) = array_values(pathinfo($this->mSrcFile));
			$oriname = sprintf('%s%s%s%s', $dirname, DIRECTORY_SEPARATOR, $this->mOriginalPrefix, $fname);
			if ($this->mSrcFile === $pDstFile) {
				copy($this->mSrcFile, $oriname);
				$filelist = array($oriname);
			} else {
				$filelist = array($this->mSrcFile);
			}
		}
		array_push($filelist, $pDstFile);

		$SrcRes = $this->CreateImage($this->mSrcFile);
		if (!$SrcRes) {
			return false;
		}

		$SaveImageFunc = 'image'. explode('/', $this->mMimeType)[1];
		if (self::IsValidPercent($pUserPercent)) {
			$w = $this->mImgWidth * $pUserPercent;
			$h = $this->mImgHeight * $pUserPercent;
		} else {
			$w = $this->mImgWidth * $this->mDefaultPercent;
			$h = $this->mImgHeight * $this->mDefaultPercent;
		}

		$DstRes = imagecreatetruecolor($w, $h);
		$CompressionFunc($DstRes, $SrcRes, 0, 0, 0, 0,
						$w, $h, $this->mImgWidth, $this->mImgHeight);

		$q = (self::IsValidQuality($pUserQuality))? $pUserQuality : $this->mDefaultQuality;
		$f = (self::IsValidFilters($pUserFilters))? $pUserFilters : $this->mDefaultFilters;
		$ret = $this->SaveImage($DstRes, $pDstFile, $q, $f);
		if ($ret) {
			return $filelist;
		}
		return $ret;
	}

	protected static function IsValidPercent($pPercent) {
		return ($pPercent > 0.0 && $pPercent < 1.0);
	}

	protected static function IsValidQuality($pQuality) {
		return ($pQuality >= 0.0 && $pQuality <= 1.0);
	}

	protected static function IsValidFilters($pFilters) {
		return ($pFilters >= 0);
	}

	public /*protected*/ static function JpgQ2PngQ($pJpgQ) {
		if (!self::IsValidQuality($pJpgQ)) {
			return false;
		}
		$pngQ10 = (1.0 - $pJpgQ) * 10;
		return ceil($pngQ10 -0.5);
	}

	protected function GetFunctionAndQuality($pFuncPrefix) {
		$mimeinfo = explode('/', $this->mMimeType);
		if ($mimeinfo[0] !== 'image') {
			return false;
		}
		$func = $pFuncPrefix.$mimeinfo[1];
		if ($mimeinfo[1] === 'jpeg') {
			$q = (int)($this->mDefaultQuality * 100);
		} else if ($mimeinfo[1] === 'png') {
			$q = self::JpgQ2PngQ($this->mDefaultQuality);
		}
		if (!function_exists($func)) {
			return false;
		}
		return array($func, $q);
	}

	protected function CreateImage($pSrcFile) {
		list($func, $q) = $this->GetFunctionAndQuality('imagecreatefrom');
		if ($func) {
			return $func($pSrcFile);
		}
		return $func;
	}

	protected function SaveImage($pDstRes, $pDstFile, $pQuality, $pFilters) {
		list($func, $q) = $this->GetFunctionAndQuality('image');
		if ($func) {
			return $func($pDstRes, $pDstFile, $q, $pFilters);
		}
		return $func;
	}
}
}// End of namespace
?>