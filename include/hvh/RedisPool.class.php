<?php
namespace hvh {

require_once 'hvh/Pool.class.php';

class RedisPool extends Pool {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	private static $mInstance = null;

	public static function GetInstance($pClass, $pCapacity = 16){
		if (is_null(self::$mInstance)) {
			self::$mInstance = new self($pClass, $pCapacity);
		}
		return self::$mInstance;
	}
}
}// End of namespace
?>