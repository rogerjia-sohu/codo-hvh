<?php
namespace hvh {

abstract class Pool {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	abstract public static function GetInstance($pClass, $pCapacity = 16);

	private $mCapacity;
	private $mPool;
	private static $instance = null;

	protected function __construct($pClass, $pCapacity) {
		$this->mCapacity = $pCapacity;
		$this->mPool = array();
		for ($i = 0; $i < $this->mCapacity; $i++) {
			$AObj = new $pClass;
			array_push($this->mPool, $AObj);
		}
	}

	public function Capacity() { return $this->mCapacity; }
	public function Size() { return count($this->mPool); }

	public function GetObj($pRetry = 3, $pDelayMillisecond = 100) {
		$microsecond = $pDelayMillisecond * 1000;
		while ($pRetry--) {
			if (count($this->mPool ) <= 0) {
				usleep($microsecond);
			} else {
				return array_pop($this->mPool);
			}
		}
		throw new \ErrorException('There is no object available in the pool, retry later.');
	}

	public function ReleaseObj(&$pObj) {
		if (count($this->mPool) >= $this->mCapacity) {
            throw new \ErrorException ('The pool is full and cannot hold any more object.');
        } else {
            array_push($this->mPool, $pObj);
			$pObj = null;
        }
	}
}
}// End of namespace
?>