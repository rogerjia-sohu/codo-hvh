<?php
namespace hvh {

class User extends UserBase {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public function __construct($pMobile = '', $pPW = '', $pType = self::TYPE_DOCTOR, $pWxCode = '') {
		// Do not change the file name which the next step relies on.
		parent::__construct($pMobile, $pPW, $pType, $pWxCode, __FILE__);
	}

	// abstract
	public function Register() {
		$serverinfo = array('errno' => 0, Lib::$Config->InterfaceName->Data => '', 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');

		$defaultname = substr($this->mMobileNum, -4) .'-'. substr($this->mID, 0, 8);
		$strfmt = "insert into `%s`(`ID`,`MobileNum`,`Name`,`Nickname`,`RegTime`,`Password`,`PortraitID`,`TypeID`)"
			."values('%s','%s','%s','%s','%s','%s','%s', %d);";
		$sql = sprintf($strfmt, 
				$this->mDBTableName, $this->mID, $this->mMobileNum,	$defaultname, $defaultname,
				$this->mRegTime, $this->mPassword, Lib::$Config->User->DefaultPortraitID, $this->mType);

		$db = Lib::DBInit();
		$db->query($sql);

		$rowcnt = $db->affected_rows;
		$dbinfo['errno'] = $db->errno;
		$dbinfo['sqlstate'] = $db->sqlstate;
		$dbinfo['error'] = $db->error;
		Lib::DBTerm($db);

		if ($rowcnt === -1) {
			$serverinfo['errno'] = 1000;
			$serverinfo[Lib::$Config->InterfaceName->Data] = array('count' => $rowcnt);
			$serverinfo['error'] = 'Register Failed';
		} else {
			$imgfm = new ImageFileManager('', 'images/user');
			$url = $imgfm->GetOneLocalFileUrl(Lib::$Config->User->DefaultPortraitID);
			$serverinfo[Lib::$Config->InterfaceName->Data] = array(
				'count' => $rowcnt,
				'userid' => $this->mID,
				'username' => $defaultname,
				'nickname' => $defaultname,
				'portrait' => $url
			);
		}

		$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		return $ret;
	}

	// abstract
	public function LogIn() {
$logfile = 'D:/wtserver/tmp/login.log';

		$argc = func_num_args();
		$argv = func_get_args();
		$lng = $argv[0];
		$lat = $argv[1];
		$devid = $argv[2];

		$serverinfo = array(Lib::$Config->InterfaceName->ErrNo => 0,
							Lib::$Config->InterfaceName->Data => '',
							Lib::$Config->InterfaceName->Error => '');
		$dbinfo = array(Lib::$Config->InterfaceName->ErrNo => 0, 
						Lib::$Config->InterfaceName->SqlState => '00000',
						Lib::$Config->InterfaceName->Error => '');

		$redis = Lib::RedisInit();
		$userdata = $redis->hgetall(self::$LoginPrefix . md5($this->mMobileNum));
		Lib::RedisTerm($redis);
		$iphash = $userdata['iphash'];		
Utils::LogToFile($logfile, "iphash=$iphash");
		if ($iphash === md5($_SERVER['REMOTE_ADDR'])) {
Utils::LogToFile($logfile, "MATCH using last session");
			$sessid = $userdata['sessionid'];
Utils::LogToFile($logfile, "last session: $sessid");
			session_id($sessid);
			@session_start();
			//$_SESSION['lastlogin'] = $lastlogin;
			$_SESSION['lng'] = $lng;
			$_SESSION['lat'] = $lat;
			$_SESSION['devid'] = $devid;

			$serverinfo[Lib::$Config->InterfaceName->Data] = array(
					'sessionid'=>$sessid,
					'userid'=>$_SESSION['UserID'],
					'mobile'=>$_SESSION['MobileNum'],
					'username'=>$_SESSION['UserName'],
					'nickname'=>$_SESSION['Nickname'],
					'portrait'=>$_SESSION['portrait'],
					'lastlogin'=>$_SESSION['lastlogin'],
					'lng'=>$_SESSION['lng'],
					'lat'=>$_SESSION['lat'],
					'devid'=>$_SESSION['devid']
					);
			$redis = Lib::RedisInit();
			$redis->touch_ttl(self::$LoginPrefix . md5($this->mMobileNum));
			Lib::RedisTerm($redis);
		} else {
Utils::LogToFile($logfile, "UNMATCH reading from DB");
			$strfmt = "select `ID`,`MobileNum`,`Name`,`Nickname`,`RegTime`,`Password`,`PortraitID`"
				." from %s where `MobileNum`='%s';";
			$sql = sprintf($strfmt, $this->mDBTableName, $this->mMobileNum);

			$db = Lib::DBInit();
			$result = $db->query($sql);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if (is_array($row) && $row['Password']===$this->mPassword) {
				@session_start();
				$sessid = session_id();
				$lastlogin = Utils::GetTimeArray(microtime(true))['timestamp'];

				$_SESSION['UserID'] = $row['ID'];
				$_SESSION['MobileNum'] = $row['MobileNum'];
				$_SESSION['UserName'] = $row['Name'];
				$_SESSION['Nickname'] = $row['Nickname'];
				$_SESSION['RegTime'] = $row['RegTime'];
				$_SESSION['PortraitID'] = $row['PortraitID'];

				$imgfm = new ImageFileManager('', 'images/user');
				$portrait = $imgfm->GetOneLocalFileUrl($_SESSION['PortraitID']);
				$_SESSION['portrait'] = $portrait;
				$_SESSION['lastlogin'] = $lastlogin;
				$_SESSION['lng'] = $lng;
				$_SESSION['lat'] = $lat;
				$_SESSION['devid'] = $devid;
				
				$serverinfo[Lib::$Config->InterfaceName->Data] = array(
					'sessionid'=>$sessid,
					'userid'=>$row['ID'],
					'mobile'=>$row['MobileNum'],
					'username'=>$row['Name'],
					'nickname'=>$row['Nickname'],
					'portrait'=>$portrait,
					'lastlogin'=>$lastlogin,
					'lng'=>$lng,
					'lat'=>$lat,
					'devid'=>$devid
					);

				$userkey = self::$LoginPrefix . md5($row['MobileNum']);
				$userdata = array(
							'sessionid' => $sessid,
							'iphash' => md5($_SERVER['REMOTE_ADDR'])
							);

				$redis = Lib::RedisInit();
				$redis->hmsetex_sessionttl($userkey, $userdata);
				Lib::RedisTerm($redis);
			} else {
				$serverinfo[Lib::$Config->InterfaceName->ErrNo] = 1001;
				$serverinfo[Lib::$Config->InterfaceName->Data] = array('count' => $db->affected_rows,
				'sessionid'=>'');
				$serverinfo[Lib::$Config->InterfaceName->Error] = 'Login Faild';
			}
			$dbinfo[Lib::$Config->InterfaceName->ErrNo] = $db->errno;
			$dbinfo[Lib::$Config->InterfaceName->SqlState] = $db->sqlstate;
			$dbinfo[Lib::$Config->InterfaceName->Error] = $db->error;
			Lib::DBTerm($db);
		}

		$usersign = new UserSign($_SESSION['UserID']);
		$usercredit = new UserCredit($_SESSION['UserID']);

		$serverinfo[Lib::$Config->InterfaceName->Data]['curtime']= Utils::GetTimeArray(microtime(true))['timestamp'];
		$serverinfo[Lib::$Config->InterfaceName->Data]['lastsignin']= $usersign->GetLastSignIn();
		$serverinfo[Lib::$Config->InterfaceName->Data]['credits']= $usercredit->GetCredit(0)['credit'];

		$ret = array(Lib::$Config->InterfaceName->Server => $serverinfo, Lib::$Config->InterfaceName->DB => $dbinfo);

		return $ret;
	}

	static function LogOut($pMobile, $pSessionID) {
		$serverinfo = array('errno' => 0, Lib::$Config->InterfaceName->Data => '', 'error' => '');
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

	public static function UpdateAvatar($pUserID, $pKeyExt) {
		$serverinfo = array('errno' => 0, Lib::$Config->InterfaceName->Data => '', 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');

		$keyinfo = explode('.', $pKeyExt);

		$strfmt = "select count(1) as ImgCnt from image_md5 where `ID`= '%s';";
		$sql = sprintf($strfmt, $keyinfo[0]);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);
		$imgcnt = (int)$result->fetch_array(MYSQLI_ASSOC)['ImgCnt'];

		$strfmt = "update `%s` set `PortraitID`='%s' where `ID`='%s';";
		$sql = sprintf($strfmt, explode('.', basename(__FILE__))[0], $keyinfo[0], $pUserID);

		$db = Lib::DBInit();
		$db->query($sql);
		Lib::DBTerm($db);

		return $ret;
	}

	protected static function GroupAndSortUser(&$pUserlist) {
		$usergroup = array();
		foreach ($pUserlist as $user) {
			$key = CUtf8_PY::encode($user['nickname'], false);
			if (array_key_exists($key, $usergroup)) {
				$curval = $usergroup[$key];
			} else {
				$curval = array();
			}
			array_push($curval, $user);
			$usergroup[$key] = $curval;
		}
	
		ksort($usergroup);

		$newlist = array();
		$sortedlist = array();
		$key = $prevkey = '';
		foreach ($usergroup as $users) {
			$key = strtoupper($users[0]['nickname'][0]);
			if (!empty($prevkey) && !($key === $prevkey)) {
				$alist['initial'] = $prevkey;
				$alist['infolist'] = $sortedlist;
				array_push($newlist, $alist);
				unset($sortedlist);
				$sortedlist = array();
			}
			foreach ($users as $usr) {
				array_push($sortedlist, $usr);
			}
			$prevkey = $key;
		}
		$alist['initial'] = $prevkey;
		$alist['infolist'] = $sortedlist;
		array_push($newlist, $alist);
		$pUserlist = $newlist;
		return;
	}

	public static function GetUserInfo($pDataArray, $pByID = true, $pAsFriendList = true) {
		$serverinfo = array('errno' => 0, Lib::$Config->InterfaceName->Data => array(), 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		if (!is_array($pDataArray) || empty($pDataArray)) {
			$ret['server']['errno'] = 2002;
			$ret['server']['error'] = 'Type of Array expected';	
			return $ret;
		}

		$valueset = implode("','", $pDataArray);
		$fieldset = '`ID`,`MobileNum`,`Name`, `Nickname`,`PortraitID`';

		//$searchfield = array( true => 'ID', false => 'Name');
		$searchfield = array( true => 'ID', false => 'MobileNum');
		$sql = sprintf("select $fieldset from `%s` where `%s` in ('$valueset')",
					explode('.', basename(__FILE__))[0], $searchfield[$pByID]);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);
		$rows = $result->fetch_all(MYSQLI_NUM);

		if (empty($rows)) {
			$ret['server']['errno'] = 2001;
			$ret['server']['error'] = 'empty result';
			return $ret;
		}

		$userlist = array();
		$title = array('userid', 'mobile', 'name', 'nickname', 'portrait');
		$imgfm = new ImageFileManager('', 'images/user');
		foreach ($rows as $arow) {
			$url = $imgfm->GetOneLocalFileUrl($arow[4]); // get image url from portraitid
			if ($url) {
				$arow[4] = $url;
			}
			array_push($userlist, array_combine($title, $arow));
		}
		//$ret['server'][Lib::$Config->InterfaceName->Data] = array('userlist' => $userlist);
		if ($pAsFriendList) {
			self::GroupAndSortUser($userlist);
			$ret['server'][Lib::$Config->InterfaceName->Data] = $userlist;
		} else {
			$ret['server'][Lib::$Config->InterfaceName->Data] = $userlist[0];
		}

		return $ret;
	}

	public static function GetUsernameByID($pUserID) {
		$ret = self::GetUserInfo(array($pUserID), true, false)['server'][Lib::$Config->InterfaceName->Data]['name'];
		return $ret;
	}

	public static function GetUserIDByName($pUsername) {
		$ret = self::GetUserInfo(array($pUsername))['server'][Lib::$Config->InterfaceName->Data]['userlist'][0]['userid'];
		return $ret;
	}

	public static function GetFriendInfo($pUser, $pByID = true) {
		$serverinfo = array('errno' => 0, Lib::$Config->InterfaceName->Data => array(), 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		$username = $pByID? self::GetUsernameByID($pUser) : $pUser;
		if (empty($username)) {
			$ret['server']['errno'] = 2003;
			$ret['server']['error'] = 'Invalid user ID specified';
			return $ret;
		}

		$ret = json_decode(EasemobHelper::GetFriend($username))->data;
		$ret = self::GetUserInfo($ret, false);
		return $ret;
	}

	public static function SetNickname($pUser, $pNickname, $pByID = true) {
		$serverinfo = array('errno' => 0, Lib::$Config->InterfaceName->Data => array(), 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		$username = $pByID? self::GetUsernameByID($pUser) : $pUser;
		if (empty($username)) {
			$ret['server']['errno'] = 2004;
			$ret['server']['error'] = 'Invalid user ID specified';
			return $ret;
		}
		//$ret = json_decode(EasemobHelper::SetNickname($username, $pNickname));
		//if ($ret->entities[0]->nickname === $pNickname) {
			$ret = self::UpdateInfo($pUser, array('Nickname' => $pNickname), $pByID);
		//}		
		return $ret;
	}
	
	public static function GetList($pType) {
		$strfmt = "select `Name`, `MobileNum` from `%s` where `TypeID`='$pType' and `Status`='1';";
		$sql = sprintf($strfmt,	explode('.', basename(__FILE__))[0]);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);

		$keynames = array('dummy','doctor', 'nurse', 'patient');
		$ret = array("$keynames[$pType]list" => $result->fetch_all(MYSQLI_ASSOC));
		return $ret;
	}
	
	public static function GetAvatar($pMobile, $pSessionID) {
		session_id($pSessionID);
		@session_start();
		$ret = array('url'=> $_SESSION['portrait']);
		return $ret;
	}

	protected static function UpdateInfo($pUser, $pInfoArray, $pByID = true) {
		$serverinfo = array('errno' => 0, Lib::$Config->InterfaceName->Data => '', 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		//$userid = $pByID? $pUser : self::GetUserIDByName($pUser);
		$userid = $pByID? self::GetUserIDByName($pUser) : $pUser;
		$cnt = count($pInfoArray);
		if ($cnt >= 1) {
			$cols = array_keys($pInfoArray);
			$vals = array_values($pInfoArray);
			for ($i = 0; $i < $cnt; $i++) {
				$colval .= sprintf("`%s`='%s'%s", 
								$cols[$i], $vals[$i], ($i == $cnt-1)? '':',');
			}
		}

		//$searchfield = array( true => 'ID', false => 'Name');
		$searchfield = array( true => 'Name', false => 'ID');
		$strfmt = "update `%s` set $colval where `%s`='%s';";
		$sql = sprintf($strfmt,
				explode('.', basename(__FILE__))[0],
				$searchfield[$pByID],
				$pUser);

		$db = Lib::DBInit();
		$db->query($sql);
		Lib::DBTerm($db);

		return $ret;
	}
}
}// End of namespace
?>