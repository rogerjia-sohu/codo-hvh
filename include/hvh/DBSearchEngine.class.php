<?php
namespace hvh {

class DBSearchEngine {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected $mDBConn;
	protected $mKeywordsExp;

	protected $mDBName;
	protected $mTableArray = array();

	public function __construct($pDBName) {
		$this->mKeywordsExp = '';
		$this->mDBName = $pDBName;

		$mDBConn = Lib::DBInit();
		if (!empty($this->mDBName)) {
			$mDBConn->select_db($this->mDBName);
		}

		Lib::DBTerm($mDBConn);
	}

	public function __destruct() {
		//
	}

	public function Search() {
		$mDBConn = Lib::DBInit();
		$result = $mDBConn->query('select Name name,MobileNum as mobile from user');
		if (1) {
			//is mysqli_result?
		$all = ['result' => $result->fetch_all()];
		}
		Lib::DBTerm($mDBConn);
		return $all;
	}
}
}// End of namespace
?>