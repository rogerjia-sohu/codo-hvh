<?php
namespace hvh {

class Redis extends \Redis {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	private $mSessionTTL;

	public function __construct() {
		parent::__construct();
		$this->connect(Lib::$Config->Redis->Host);
		$this->mSessionTTL = ini_get('session.gc_maxlifetime');
	}

	public function setex_sessionttl($pKey, $pVal) {
		$this->setex($pKey, $this->mSessionTTL, $pVal);
	}

	public function hsetex_sessionttl($pKey, $pField, $pVal) {
		$ret = $this->multi()
			->hset($pKey, $pField, $pVal)
			->expire($pKey, $this->mSessionTTL)
			->exec();
		return $ret;
	}

	public function hmsetex_sessionttl($pKey, $pFieldArr, $pValArr = null) {
		if (!is_array($pFieldArr)) {
			return false;
		}

		if (!is_array($pValArr) || count($pValArr) == 0) {
			$ret = $this->multi()
				->hmset($pKey, $pFieldArr)
				->expire($pKey, $this->mSessionTTL)
				->exec();
		} else {
			$ret = $this->multi()
				->hmset($pKey, array_combine($pFieldArr, $pValArr))
				->expire($pKey, $this->mSessionTTL)
				->exec();
		}

		return $ret;
	}
	
	public function touch_ttl($pKey) {
		$this->expire($pKey, $this->mSessionTTL);
	}
}
}// End of namespace
?>