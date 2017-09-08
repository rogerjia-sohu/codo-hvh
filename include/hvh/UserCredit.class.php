<?php
namespace hvh {

class UserCredit {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public const CURRENT_CREDIT = 0;
	public const USED_CREDIT = 1;
	public const TOTAL_CREDIT = 2;
	
	protected static $mTableName = 'user_credit';
	protected static $mRuleTableName = 'user_credit_rule';
	protected static $mCreditArr = array(
		'Current', 'Used', 'Total'
	);
	
	protected $mUserID;

	public function __construct($pUserID) {
		$this->mUserID = $pUserID;
	}

	public function GetCredit($pType) {
		$ret = array(
			'getcredit' => 'err',
			'credit' => '0',
			'error' => ''
		);

		$field = self::$mCreditArr[$pType % count(self::$mCreditArr)];
		
		$db = Lib::DBInit();
		$strfmt = "select `$field` from `%s` where `UserID`='%s';";
		$sql = sprintf($strfmt, self::$mTableName, $this->mUserID);
		$result = $db->Query($sql);
		if ($db->affected_rows === 1){
			$credit = $result->fetch_array(MYSQLI_NUM)[0];
			$ret['getcredit'] = 'ok';
			$ret['credit'] = (int)$credit;
		} else {
			$ret['error'] = 'db failure';
		}
		Lib::DBTerm($db);
		
		return $ret;
	}

	public function SetCredit($pRuleID) {
		$ret = array(
			'setcredit' => 'err',
			'credit' => 0,
			'error' => ''
		);

 		$strfmt = "select a.`Current`, b.`Value` from `%s` a, `%s` b "
				."where a.`UserID`='%s' and`ID`='$pRuleID' and b.`Status`=1;";
		$sql = sprintf($strfmt, self::$mTableName, self::$mRuleTableName,$this->mUserID);

		$db = Lib::DBInit();
		$result = $db->Query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		$curvalue = (int)$row[0];
		$rulevalue = (int)$row[1];
		$ret['credit'] = $curvalue;
		$newcur = $curvalue + $rulevalue;
		if ($newcur >=0) {	
			if ($rulevalue < 0) {
				$strfmt = "update `%s` set `Used`=`Used` - $rulevalue";
			} else {
				$strfmt = "update `%s` set `Total`=`Total` + $rulevalue";
			}
			$strfmt .= ", `Current`=`Current` + $rulevalue where `UserID`='%s'";
			$sql = sprintf($strfmt, self::$mTableName, $this->mUserID);
			$db->Query($sql);
			if ($db->affected_rows === 1) {
				$ret['setcredit'] = 'ok';
				$ret['credit'] = $newcur;
			} else {
				$ret['error'] = 'db failure';
			}
		} else {
			$ret['error'] = 'low balance';
		}
		Lib::DBTerm($db);

		unset($result);
		unset($row);

		return $ret;
	}
}
}// End of namespace
?>