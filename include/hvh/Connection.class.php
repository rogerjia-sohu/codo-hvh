<?php
namespace hvh {

class Connection extends \mysqli {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct() {
		// do not use a persistent connection which may cause (08004/1040)
		parent::__construct(Lib::$Config->DB->Host);
		$this->set_charset(Lib::$Config->DB->Charset);
		$this->select_db(Lib::$Config->DB->DBName);
	}

	public function __destruct() {
		$this->close();
	}
	
	public function table_exists($pTableName) {
		return (($this->query("show tables like '$pTableName'"))->num_rows === 1);
	}
}
}// End of namespace
?>