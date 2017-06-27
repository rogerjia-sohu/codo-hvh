<?php
namespace hvh {

class Action {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public static $Config;
	public static $List;
	private static $DefaultConfig =
'{
	"Config": {
	},
	"Description": {
	}
}';

	private static $DefaultList =
'{
	"test": {
		"Func": "Test",
		"Args": ["doc", "usr"]
	},
	"register": {
		"Func": "Register",
		"Args": ["mobile", "pw", "doctor"]
	},
	"login": {
		"Func": "LogIn",
		"Args": ["mobile", "pw", "wxcode"]
	},
	"logout": {
		"Func": "LogOut",
		"Args": ["mobile", "sessionid"]
	},
	"chpwd": {
		"Func": "ChangePassword",
		"Args": ["mobile", "pw", "newpw"]
	},
	"rstpwd": {
		"Func": "ResetPassword",
		"Args": ["mobile", "pw", "newpw"]
	},
	"getval": {
		"Func": "GetValue",
		"Args": ["mobile", "sessionid", "paramlist"]
	},
	"setval": {
		"Func": "SetValue",
		"Args": ["mobile", "sessionid", "paramlist"]
	},
	"wxtxtmsg": {
		"Func": "WxTextMsg",
		"Args": ["sessionid"]
	},
	"sendsms": {
		"Func": "SendSMS",
		"Args": ["mobile", "msg"]
	},
	"gensmscode": {
		"Func": "GenSMSCode",
		"Args": ["mobile", "digit", "ttl", "maxhits"]
	},
	"chksmscode": {
		"Func": "ChkSMSCode",
		"Args": ["mobile", "code"]
	},
	"page": {
		"Func": "GetPage",
		"Args": ["what", "start", "count"]
	},
	"genuuid": {
		"Func": "GenUUID",
		"Args": []
	},
	"servertime": {
		"Func": "GetServerTime",
		"Args": []
	},
	"dbtime": {
		"Func": "GetDBTime",
		"Args": []
	},
	"chkid18": {
		"Func": "CheckID18",
		"Args": ["id"]
	},
	"chatmsg": {
		"Func": "ChatMessage",
		"Args": ["from", "to", "txt", "img"]
	},
	"order": {
		"Func": "PlaceOrder",
		"Args": ["userid", "docid", "svcid"]
	},
	"uploadphoto": {
		"Func": "UploadPhoto",
		"Args": ["mobile", "sessionid"]
	},
	"chatrecord": {
		"Func": "ChatRecord",
		"Args": ["time"]
	},
	"silk2amr": {
		"Func": "Silk2Amr",
		"Args": []
	},
	"clientdl": {
		"Func": "ClientDownloadFile",
		"Args": ["url"]
	},
	"userinfo": {
		"Func": "GetUserInfo",
		"Args": ["mobile", "sessionid", "users"]
	},
	"friendinfo": {
		"Func": "GetFriendInfo",
		"Args": ["mobile", "sessionid"]
	},
	"userchatrecord": {
		"Func": "UserChatRecord",
		"Args": ["mobile", "sessionid", "time"]
	},
	"setnickname": {
		"Func": "SetNickname",
		"Args": ["mobile", "sessionid", "name"]
	}
}';

	public static function Register($pParamArray) {
		$serverinfo = array('errno' => 2000, 'data' => '', 'error' => 'Invalid request');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		$paramcnt = count($pParamArray);
		if (is_array($pParamArray) &&  $paramcnt >= 2) {
			if ($paramcnt === 2) {
				$mobile = $pParamArray[0];
				$pw = $pParamArray[1];
				$user = new User($mobile, $pw);
				$ret = $user->Register();
				$username = $ret['server']['data']['username'];
				$nickname = $ret['server']['data']['nickname'];
				if (!empty($username)) {
					//EasemobHelper::CreateUser($username, $pParamArray[1]);
					EasemobHelper::CreateUser($mobile, $pw);
					EasemobHelper::SetNickname($mobile, $nickname);
				}
			} else if ($pParamArray[2] == 'doctor') {
				//$doctor = new Doctor($pParamArray[0], $pParamArray[1]);
				//$ret = $doctor->Register();
				$ret = 'doctor registration';
			}
		}
		return Utils::FormatReturningData($ret);
	}

	public static function LogIn($pParamArray) {
		$argc = count($pParamArray);
		if (is_array($pParamArray) && ($argc === 2 || $argc === 3)) {
			if ($argc === 3) {
				$user = new User($pParamArray[0], $pParamArray[1], $pParamArray[2]);
			} else {
				$user = new User($pParamArray[0], $pParamArray[1]);
			}
			$ret = $user->LogIn();
		} else {
			$serverinfo = array('errno' => 2001, 'data' => '', 'error' => 'Invalid request');
			$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
			$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function LogOut($pParamArray) {
		if (is_array($pParamArray) && count($pParamArray) === 2) {
			$ret = User::LogOut($pParamArray[0], $pParamArray[1]);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function ChangePassword($pParamArray) {
		//$pMobile, $pCurPW, $pNewPW
		$ret = 'Change Password';
		if (is_array($pParamArray) && count($pParamArray) === 3) {
			//$user = new User($pParamArray[0], $pParamArray[1]);
			//$ret = $user->Register();
		} else {
			$serverinfo = array('errno' => 2000, 'data' => '', 'error' => 'Invalid request');
			$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
			$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		}

		return Utils::FormatReturningData($ret);
	}

	public static function ResetPassword($pParamArray) {
		//$pMobile, $pCurPW, $pNewPW
		$ret = 'Reset Password';
		if (is_array($pParamArray) && count($pParamArray) === 3) {
			//$user = new User($pParamArray[0], $pParamArray[1]);
			//$ret = $user->Register();
		} else {
			$serverinfo = array('errno' => 2000, 'data' => '', 'error' => 'Invalid request');
			$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
			$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function GetValue($pParamArray) {
		//$pMobile, $pSessID, $pParamList
		$ret = 'GetValue';
		if (is_array($pParamArray) && count($pParamArray) === 3) {
			//
		} else {
			$serverinfo = array('errno' => 2000, 'data' => '', 'error' => 'Invalid request');
			$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
			$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function SetValue($pParamArray) {
		//$pMobile, $pSessID, $pParamList
		$ret = 'SetValue';
		if (is_array($pParamArray) && count($pParamArray) === 3) {
			//
		} else {
			$serverinfo = array('errno' => 2000, 'data' => '', 'error' => 'Invalid request');
			$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
			$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function WxTextMsg($pParamArray) {
		//$pToUser, $pFromUser, $pContent
		$ret = 'WxTextMsg';
		$wx = new WeiXin();
		//$wx->TextMsg(array());
		return Utils::FormatReturningData($ret);
	}

	public static function SendSMS($pParamArray) {
		if (is_array($pParamArray) && count($pParamArray) === 2) {
			$sms = Lib::HJSmsInit();
$ret = $sms->TextMsgTemplate($pParamArray[0], $pParamArray[1]);
//$ret = $sms->Balance();
			Lib::HJSmsTerm($sms);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function GenSMSCode($pParamArray) {
		$paramcnt = count($pParamArray);
		if (is_array($pParamArray) && $paramcnt >= 3) {
			$mobile = $pParamArray[0];
			$digit = $pParamArray[1];
			$redisttl = $pParamArray[2];
			if ($paramcnt === 4) {
				$maxhits = $pParamArray[3];
			}
			$ret = RedisSMSCode::GenCode($mobile, $digit, $redisttl, $maxhits);
		}
		return Utils::FormatReturningData($ret);
	}
	public static function ChkSMSCode($pParamArray) {
		if (is_array($pParamArray) && count($pParamArray) === 2) {
			$mobile = Utils::GetHttpValue('mobile');
			$code = Utils::GetHttpValue('code');
			$ret = RedisSMSCode::CheckCode($mobile, $code);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function GetPage($pParamArray) {
		if (is_array($pParamArray) && count($pParamArray) >=1) {
			$what = Utils::GetHttpValue('what');
			$start = Utils::GetHttpValue('start');
			$count = Utils::GetHttpValue('count');
			if (strcasecmp($what, 'hospital') == 0) {
				$ret = PageManager::Page([new Hospital(), $start, $count]);
			}
		}
		return Utils::FormatReturningData($ret);
	}

	public static function GenUUID($pParamArray) {
		return Utils::FormatReturningData(['uuid' => uuid::yacomb()]);
	}

	public static function GetServerTime($pParamArray) {
		$ret = array( 'servertime' => self::GetTimeArray(microtime(true)));
		return Utils::FormatReturningData($ret);
	}

	public static function GetDBTime($pParamArray) {
		$db = Lib::DBInit();
		$result = $db->Query('select UNIX_TIMESTAMP();');
		Lib::DBTerm($db);

		$ret = array( 'dbtime' => self::GetTimeArray($result->fetch_array(MYSQLI_NUM)[0]));
		return Utils::FormatReturningData($ret);
	}

	private static function GetTimeArray($pTimestamp) {
		var_dump($pTimestamp);
		return array(
				'year' => (int)date('Y', $pTimestamp),
				'month' => (int)date('m', $pTimestamp),
				'day' => (int)date('d', $pTimestamp),
				'hour' => (int)date('H', $pTimestamp),
				'minute' => (int)date('i', $pTimestamp),
				'second' => (int)date('s', $pTimestamp),
				'millisecond' => (int)(($pTimestamp - (int)$pTimestamp) * 1000),
				'leap' => (int)date('L', $pTimestamp),
				'timestamp' => (int)$pTimestamp
				);
	}

	public static function utf8_array_asort(&$array) {
  if(!isset($array) || !is_array($array)) {
   return false;
  }
  foreach($array as $k=>$v) {
   $array[$k] = iconv('UTF-8', 'GBK//IGNORE',$v);
  }
  asort($array);
  foreach($array as $k=>$v) {
   $array[$k] = iconv('GBK', 'UTF-8//IGNORE', $v);
  }
  return true;
}
	public static function Test() {
		// Holds any testing/debugging codes
	}

	public static function CheckID18($pParamArray) {
		$ret = false;
		if (is_array($pParamArray) && count($pParamArray) === 1) {
			$ret = IDCard::CheckNumber($pParamArray[0]);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function ChatMessage($pParamArray) {
		$ret = false;
		if (is_array($pParamArray) && count($pParamArray) >= 3) {
			$from = $pParamArray[0];
			$to = $pParamArray[1];
			$txt = $pParamArray[2];
			if (count($pParamArray) > 3) {
				$img = $pParamArray[3];
			}
			echo sprintf('%s told %s: "%s" and sent an image of [%s]<br/>', $from, $to, $txt, $img);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function PlaceOrder($pParamArray) {
/*
		$serverinfo = array('errno' => 2000, 'data' => '', 'error' => 'Invalid request');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);
*/
		$ret = false;

		if (is_array($pParamArray) && count($pParamArray) === 3) {
			$userid = $pParamArray[0];
			$docid = $pParamArray[1];
			$svcid = $pParamArray[2];
			echo sprintf('User [%s] placed an order to doctor [%s] of a [%s] service<br/>', $userid, $docid, $svcid);
			//$ret = null;
			$order = new Order('uid', 'did', 'sid', 'desc');
			var_dump($order);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function UploadPhoto($pParamArray) {
		$ret = false;
		$files = Utils::GetAllPostedFileInfo();

		if (is_array($pParamArray) && count($pParamArray) === 2) {
			$mobile = $pParamArray[0];
			$sessionid = $pParamArray[1];
			$ret = User::IsLoggedIn($mobile, $sessionid);
			if ($ret) {
				foreach ($files as $fileinfo) {					
					$fm = new ImageFileManager($_SERVER['DOCUMENT_ROOT'], 'images/user');
					if (is_array($fileinfo['name'])) {
						$orgext = '.'.pathinfo($fileinfo['name'][0], PATHINFO_EXTENSION);
						$tmpfile = $_FILES['filelist']['tmp_name'][0];
					} else {
						$orgext = '.'.pathinfo($fileinfo['name'], PATHINFO_EXTENSION);
						$tmpfile = $_FILES['filelist']['tmp_name'];
					}
					$tmpfile_w_orgext = $tmpfile . $orgext;
					rename($tmpfile, $tmpfile_w_orgext);
					$hkey = '';
					$ret = $fm->SaveFile($tmpfile_w_orgext, null, true, $hkey);
					unlink($tmpfile_w_orgext);

					session_id($sessionid);
					@session_start();
					User::UpdatePhoto($_SESSION['UserID'], $hkey.$orgext);
					break; // handles only the first file posted
				}
			}
		}
		return ($ret);
	}

	public static function ChatRecord($pParamArray) {
		$ret = 'retry later';
		if (is_array($pParamArray) && count($pParamArray) === 1) {
			$time = $pParamArray[0]; // yyyymmddhh，10位
			$ret = EasemobHelper::GetChatRecord($time);
		} else {
			// ?
		}
		return Utils::FormatReturningData($ret);
	}

	public static function Silk2Amr($pParamArray) {
		$silkfile = $_FILES;
		$fm = new Silk2AmrFileManager();
		foreach ($silkfile as $asilk) {
			if (is_array($asilk['name'])) {
				$orgext = '.'.pathinfo($asilk['name'][0], PATHINFO_EXTENSION);
				$tmpfile = $asilk['tmp_name'][0];
			} else {
				$orgext = '.'.pathinfo($asilk['name'], PATHINFO_EXTENSION);
				$tmpfile = $asilk['tmp_name'];
			}
			$tmpfile_w_orgext = $tmpfile . $orgext;
			rename($tmpfile, $tmpfile_w_orgext);
			$fid = '';
			$ret = $fm->SaveFile($tmpfile_w_orgext, null, true, $fid);
			$realfile = $fm->RealFilePath($fid);
			if ($fm->ToAmr($realfile)) {
				$ret = str_ireplace('.silk', '.amr',$ret);
			}
			unlink($tmpfile_w_orgext);
		}
		return ($ret);
	}

	public static function ClientDownloadFile($pParamArray) {
		if (is_array($pParamArray) && count($pParamArray) === 1) {
			$fileurl = $pParamArray[0];
			$ret = Utils::ClientDownloadFile($fileurl);
		} else {
			// ?
		}
		return Utils::FormatReturningData($ret);
	}

	public static function GetUserInfo($pParamArray) {
		$serverinfo = array('errno' => 2008, 'data' => '', 'error' => 'Invalid request');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		if (is_array($pParamArray) && count($pParamArray) === 3) {
			$mobile = $pParamArray[0];
			$sessionid = $pParamArray[1]; // session
			$idlist = explode(',',$pParamArray[2]);
			if (User::IsLoggedIn($mobile, $sessionid)) {
				session_id($sessionid);
				@session_start();
				$ret = User::GetUserInfo($idlist);
			} else {
				$ret['server']['error'] = 'user not logged in';
			}
		} else {
			// ?
		}

		return Utils::FormatReturningData($ret);
	}

	public static function GetFriendInfo($pParamArray) {
		$serverinfo = array('errno' => 2008, 'data' => '', 'error' => 'Invalid request');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		if (is_array($pParamArray) && count($pParamArray) === 2) {
			$mobile = $pParamArray[0];
			$sessionid = $pParamArray[1]; // session
			if (User::IsLoggedIn($mobile, $sessionid)) {
				session_id($sessionid);
				@session_start();
				//$ret = User::GetFriendInfo($_SESSION['UserID']);
				$ret = User::GetFriendInfo($mobile, false);
			} else {
				$ret['server']['error'] = 'user not logged in';
			}
		} else {
			// ?
		}
		return Utils::FormatReturningData($ret);
	}

	public static function UserChatRecord($pParamArray) {
		$serverinfo = array('errno' => 2008, 'data' => '', 'error' => 'Invalid request');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		echo "### UserChatRecord, NOT finished yet!<br>";

		if (is_array($pParamArray) && count($pParamArray) === 3) {
			$mobile = $pParamArray[0];
			$sessionid = $pParamArray[1]; // session
			$time = $pParamArray[2];
			if (User::IsLoggedIn($mobile, $sessionid)) {
				//session_id($sessionid);
				//@session_start();
				//$ret = User::GetUserInfo($idlist);
				if ($time > 0) {
					echo "<br>### get records after $time<br>";
				} else {
					echo '<br>### get all records<br>';
				}
			} else {
				$ret['server']['error'] = 'user not logged in';
			}
		} else {
			// ?
		}
		return Utils::FormatReturningData($ret);
	}

	public static function SetNickname($pParamArray) {
		$serverinfo = array('errno' => 2008, 'data' => '', 'error' => 'Invalid request');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		if (is_array($pParamArray) && count($pParamArray) === 3) {
			$mobile = $pParamArray[0];
			$sessionid = $pParamArray[1]; // session
			$nickname = $pParamArray[2];
			if (User::IsLoggedIn($mobile, $sessionid)) {
				session_id($sessionid);
				@session_start();
				$ret = json_decode(EasemobHelper::SetNickname($mobile, $nickname));
				if ($ret->entities[0]->nickname === $nickname) {
					$ret = User::SetNickname($_SESSION['UserID'], $nickname, false);
				}
			} else {
				$ret['server']['error'] = 'user not logged in';
			}
		} else {
			// ?
		}
		return Utils::FormatReturningData($ret);
	}
////////////////////////////////////////////////////////////////
	public static function ProcessRequest($pActionKeyword = 'action') {
		$ret = '';
		if (is_null(self::$List)) {
			return 'invalid action list';
		}

		$key = Utils::GetHttpValue($pActionKeyword);
		$action = self::$List->$key;

		if (is_null($action)) {
			return 'action not existed';
		}

		$func = $action->Func;
		$args = $action->Args;

		$cnt = count($args);
		for($i = 0; $i < $cnt; $i++) {
			$val = Utils::GetHttpValue($args[$i]);
			if (is_null($val)) {
				array_splice($args, $i, 1);
				--$i;
				$cnt = count($args);
			} else {
				if (!empty($val)) {
					$args[$i] = $val;
				}
			}
		}

		$ret = self::$func($args);
		return $ret;
	}

	public static function GetConfig() {
		$cfg = null;
		$fn = __DIR__ . str_replace(__NAMESPACE__,'', __CLASS__).'.json';
		if (file_exists($fn)) {
			$cfg = json_decode(file_get_contents($fn))->Config;
		}
		if (is_null($cfg)) {
			$cfg = json_decode(self::$DefaultConfig)->Config;
			file_put_contents($fn, self::$DefaultConfig);
		}
		return $cfg;
	}

	public static function GetList() {
		$list = null;
		$fn = __DIR__ . str_replace(__NAMESPACE__,'', __CLASS__).'.List.json';
		if (file_exists($fn)) {
			$list = json_decode(file_get_contents($fn));
		}
		if (is_null($list)) {
			$list = json_decode(self::$DefaultList);
			file_put_contents($fn, self::$DefaultList);
		}
		return $list;
	}
}
Action::$Config = Action::GetConfig();
Action::$List = Action::GetList();
}// End of namespace
?>