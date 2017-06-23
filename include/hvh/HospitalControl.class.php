<?php
namespace hvh {

require_once 'hvh/Hospital.class.php';

class HospitalControl {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected $mPreferredDBTalbeName;
	protected $mHospitalList = array();

	public function __construct() {
		$this->mPreferredDBTalbeName = 'Hospital';
	}

	public function HospitalCount() {
		$tblname = (is_array($mHospitalList) && count($mHospitalList) > 0)?
					$this->mHospitalList[0]->GetDBTableName() : $this->mPreferredDBTalbeName;

		$db = Lib::DBInit();
		$result = $db->query(sprintf('select count(1) from %s where `Status`=1;', $tblname));
		$row = $result->fetch_array();
		Lib::DBTerm($db);
		return (count($row) > 0)? (int)$row[0] : 0;
	}
	
	public function GetInfoList($pParamArray) {
		//foreach
	}
}
}// End of namespace
?>