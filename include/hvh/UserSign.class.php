<?php
namespace hvh {

class UserSign {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected static $mTableName = 'user_sign';
	protected $mUserID;

	public function __construct($pUserID) {
		$this->mUserID = $pUserID;
	}

	public function GetLastSignIn() {
		$strfmt = "select `LastSignIn` from `%s` where `UserID`='%s' and `Status`=1";
		$sql = sprintf($strfmt, self::$mTableName, $this->mUserID);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);
		$ret = (int)($result->fetch_array(MYSQLI_NUM)[0]);

		return $ret;
	}

	public function SignIn() {
		$lastsignin = $this->GetLastSignIn();
		$curtime = time();

		$d1 = date('Ymd', $lastsignin);
		$d2 = date('Ymd', $curtime);

		$chkDate = false;
		if ($chkDate && ($d1 === $d2)) {
			$ret = array('signin' => 'err');
		} else {
			$strfmt = "update `%s` set `LastSignIn`=%s where `UserID`='%s' and `Status`=1;";
			$sql = sprintf($strfmt, self::$mTableName, $curtime, $this->mUserID);
			$db = Lib::DBInit();
			$db->Query($sql);
			if ($db->affected_rows === 1) {
				$ret = array('signin' => 'ok');
				//self::AddCredit('signin');
				
			} else {
				echo "OK";
				$ret = array('signin' => 'err');
			}
			Lib::DBTerm($db);
		}

		return $ret;
	}
}
}// End of namespace
?>