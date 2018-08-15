<?php
namespace hvh {

class SystemConfig {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected const TableName = 'system_config';

	public static function GetConfig($pCfgName) {
		$strfmt = "select `Name`,`Value`,`Comment`"
			. "from `%s` "
			. "where `Name` = '%s' and Status = 1";
		$sql = sprintf($strfmt, self::TableName, $pCfgName);
		$db = Lib::DBInit();
		$result = $db->query($sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if (is_array($row)) {
			$ret = $row;
		}
		Lib::DBTerm($db);
		return $ret;
	}

	public static function SetConfig($pCfgName, $pCfgValue, $pComment = NULL) {
		$strfmt = "replace into %s(`Name`, `Value`, `Comment`) values('%s', '%s', '%s');";
		$sql = sprintf($strfmt, self::TableName, $pCfgName, $pCfgValue, $pComment);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		$dbinfo['errno'] = $db->errno;
		$dbinfo['sqlstate'] = $db->sqlstate;
		$dbinfo['error'] = $db->error;
		Lib::DBTerm($db);

		$ret = $dbinfo;
		return $ret;
	}

	public static function Turn($pCfgName, $pOnOff = 1) {
		$status = ($pOnOff == 0)? 0 : 1;
		$strfmt = "update %s set `Status` = %s where `Name` = '%s';";
		$sql = sprintf($strfmt, self::TableName, $status, $pCfgName);
		$db = Lib::DBInit();
		$result = $db->query($sql);
		$ret = $db->affected_rows;
		Lib::DBTerm($db);
		return $ret;
	}

	public static function Enable($pCfgName) {
		return self::Turn($pCfgName, 1);
	}

	public static function Disable($pCfgName) {
		return self::Turn($pCfgName, 0);
	}
}
}// End of namespace
?>