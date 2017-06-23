<?php
namespace hvh {

class Doctor extends UserBase {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct($pMobile = '', $pPW = '', $pWxCode = '') {
		// Do not change the file name which the next step relies on.
		parent::__construct($pMobile, $pPW, $pWxCode, __FILE__);
	}

	// abstract
	public function Register() {
		$serverinfo = array('errno' => 0, 'data' => '', 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');

		$strfmt = "insert into `%s`(`ID`,`MobileNum`,`Name`,`RegTime`,`Password`)"
			."values('%s','%s','%s','%s','%s');";
		$sql = sprintf($strfmt, 
				$this->mDBTableName, $this->mID, $this->mMobileNum, 'Skytree', $this->mRegTime,
				$this->mPassword);

		$db = Lib::DBInit();
		$db->query($sql);

		$rowcnt = $db->affected_rows;
		if ($rowcnt === -1) {
			$serverinfo['errno'] = 1000;
			$serverinfo['data'] = array('count' => $rowcnt);
			$serverinfo['error'] = 'Register Failed';
		}

		$dbinfo['errno'] = $db->errno;
		$dbinfo['sqlstate'] = $db->sqlstate;
		$dbinfo['error'] = $db->error;
		Lib::DBTerm($db);

		$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		return $ret;
	}
	
	// abstract
	public function LogIn() {
		$serverinfo = array('errno' => 0, 'data' => '', 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');

		$redis = Lib::RedisInit();
		$userdata = $redis->hgetall(self::$LoginPrefix . md5($this->mMobileNum));
		Lib::RedisTerm($redis);
		$iphash = $userdata['iphash'];
		if ($iphash === md5($_SERVER['REMOTE_ADDR'])) {
			$sessid = $userdata['sessionid'];
			$serverinfo['data'] = array('sessionid'=>$sessid);
			session_id($sessid);
			@session_start();

			$redis = Lib::RedisInit();
			$redis->touch_ttl(self::$LoginPrefix . md5($this->mMobileNum));
			Lib::RedisTerm($redis);
		} else {
			$strfmt = "select `ID`,`MobileNum`,`Name`,`RegTime`,`Password`"
				." from %s where `MobileNum`='%s';";
			$sql = sprintf($strfmt, $this->mDBTableName, $this->mMobileNum);

			$db = Lib::DBInit();
			$result = $db->query($sql);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if (is_array($row) && $row['Password']===$this->mPassword) {
				@session_start();
				$sessid = session_id();

				$serverinfo['data'] = array('sessionid'=>$sessid);
				$_SESSION['UserID'] = $row['ID'];
				$_SESSION['MobileNum'] = $row['MobileNum'];
				$_SESSION['UserName'] = $row['Name'];
				$_SESSION['RegTime'] = $row['RegTime'];

				$userkey = self::$LoginPrefix . md5($row['MobileNum']);
				$userdata = array(
							'sessionid' => $sessid,
							'iphash' => md5($_SERVER['REMOTE_ADDR'])
							);

				$redis = Lib::RedisInit();
				$redis->hmsetex_sessionttl($userkey, $userdata);
				Lib::RedisTerm($redis);
			} else {
				$serverinfo['errno'] = 1001;
				$serverinfo['data'] = array('count' => $db->affected_rows,
				'sessionid'=>'');
				$serverinfo['error'] = 'Login Faild';
			}
			$dbinfo['errno'] = $db->errno;
			$dbinfo['sqlstate'] = $db->sqlstate;
			$dbinfo['error'] = $db->error;
			Lib::DBTerm($db);
		}

		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		return $ret;
	}

	static function LogOut($pMobile, $pSessionID) {
		$serverinfo = array('errno' => 0, 'data' => '', 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');

		$redis = Lib::RedisInit();
		$userdata = $redis->hgetall(self::$LoginPrefix . md5($pMobile));
		Lib::RedisTerm($redis);
		$iphash = $userdata['iphash'];
		$sessid = $userdata['sessionid'];

		if (($iphash === md5($_SERVER['REMOTE_ADDR']))
			&& ($pSessionID == $sessid) ) {

			session_id($sessid);
			@session_start();
			$_SESSION = array();
			@session_destroy();

			$redis = Lib::RedisInit();
			$redis->expire(self::$LoginPrefix . md5($pMobile), 0);
			Lib::RedisTerm($redis);
		}

		$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		return $ret;
	}
}
}// End of namespace
?>