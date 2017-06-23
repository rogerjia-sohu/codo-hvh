<?php
namespace hvh {

class DBUtils {
	private const MAJOR_VER = 1;
	private const MINOR_VER = 0;
	private const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public static function TableExists($pTableName) {
		$db = Lib::DBInit();
		$ret = $db->table_exists($pTableName);
		Lib::DBTerm($db);
		return $ret;
	}

}
}// End of namespace
?>