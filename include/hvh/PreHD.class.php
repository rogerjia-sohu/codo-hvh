<?php
namespace hvh {

class PreHD {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public static function Do($pParamArray) {
		$op = $pParamArray[0];
		if ($op == 'get') {
			$ret = self::Get($pParamArray);
		} else if ($op == 'set') {
			$ret = self::Set($pParamArray);
		} else {
			$ret = __METHOD__  . ' unknown op';
		}
		return $ret;
	}
	
	protected static function Get(&$pParamArray) {
		$op = $pParamArray[0];
		$uid = $pParamArray[1];
		$ret = __METHOD__ . "$uid";
		
		$strfmt = "select b.`Name`, a.`CaseNo`, a.`Date`, a.`Duration`, a.`DevType`,"
				."a.`SickBedNo`, a.`HDTube`, a.`PreWeight`, a.`DryWeight`, a.`Dehydration`,"
				."a.`EstDehydration`, a.`PreTemperature`, a.`StartSBP`, a.`StartLBP`, a.`Bleeding`,"
				."a.`Fever`, a.`SkinInfoID`, a.`InternalFistulaInfoID`, a.`ArmNeedling`, a.`Vein`,"
				."a.`PassageMode`, a.`VesselType`, a.`PunctureCount`, a.`PunctureNeedle`, a.`DressingChange`,"
				."a.`Remark` "
				."from `hdinfo_prehd` a, `user` b "
				."where a.`UserID`=b.`ID`"
				."and a.`Status`='1'";
		$sql = $strfmt;
		$db = Lib::DBInit();
		$result = $db->Query($sql);
		Lib::DBTerm($db);

		$data = array();
		foreach ($result as $row) {
			array_push($data, $row);
		}
		$ret = array("preHD" => $data);

		return $ret;
	}
	
	protected static function Set(&$pParamArray) {
		$op = $pParamArray[0];
		$uid = $pParamArray[1];
		$ret = __METHOD__;
		return $ret;
	}
}
}// End of namespace
?>