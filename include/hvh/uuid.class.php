<?php
namespace hvh {

class uuid {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public static function v4() {
		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
		$charid = md5(uniqid(rand(), true));
		$hyphen = chr(45);// '-'
		$uuid = substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12);
		return $uuid;
	}

	public static function v4raw() {
		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
		$charid = md5(uniqid(rand(), true));
		$uuid = substr($charid, 0, 8)
			.substr($charid, 8, 4)
			.substr($charid,12, 4)
			.substr($charid,16, 4)
			.substr($charid,20,12);
		return $uuid;
	}

	public static function yacomb() {
		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
		$charid = md5(uniqid(rand(), true));
		$comb = dechex(date('Ymd')).dechex(time());
		$hyphen = chr(45);// '-'
		$uuid = substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($comb,-12);
		return $uuid;
	}

	public static function example() {
		printf('uuid::v4() -- Produces a string of uuid in version 4 like:<br>');
		printf('%s<br>', uuid::v4());
		print('<p>');
		printf('uuid::yacomb() -- Produces a string of uuid in COMB format like:<br>');
		printf('%s<br>', uuid::yacomb());
	}
}
}// End of namespace
?>