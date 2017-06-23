<?php
namespace hvh {

class Debug {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	private static $mInstance;
	private $mEnabled;

	public static function GetInstance() {
		if (is_null(self::$mInstance)) {
			self::$mInstance = new self();
		}
		return self::$mInstance;
	}

	protected function __construct() {
		$this->mEnabled = true;
	}

	public function On() { $this->mEnabled = true; }
	public function Off() { $this->mEnabled = false; }

	public function Out($pMsg) {
		if (!$this->mEnabled) { return; }
		echo __FILE__ .$pMsg;
	}
}
}// End of namespace
?>
