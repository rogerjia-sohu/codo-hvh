<?php
namespace hvh {

class Tester {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected $mSender;
	protected $mCoe;
	protected $mArgv;

	public function __construct($pSender, $pCoe = 1) {
		$this->mSender = $pSender;
		$this->mCoe = ($pCoe >= 1)? $pCoe: 1;
		return $ret;
	}

	public function Test(&$pArgv) {
		// Holds any testing/debugging code
		$this->InitArgv($pArgv);
		$argv = &$this->mArgv;

		$maxtime = ini_get(max_execution_time);
		ini_set(max_execution_time, $maxtime * $this->mCoe);

		// TODO
		echo 'Adding test code in ' . __METHOD__ . ' ('. __FILE__ . ':'.__LINE__ .')<br>';
		//$ret = Utils::FormatReturningData($this->mArgv);

		ini_set(max_execution_time, $maxtime);
		return $ret;
	}

	protected function InitArgv(&$pArgv) {
		$cnt = 0;
		foreach ($pArgv as $arg) {
			$kv = explode('=', $arg);
			$k[$cnt] = $kv[0];
			$v[$cnt] = $kv[1];
			$cnt++;
		}
		$this->mArgv = array_combine($k, $v);
	}
}
}// End of namespace
?>