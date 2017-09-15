<?php
namespace hvh {

class Action {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

//	public static $Config;
	public static $List;
/*
	private static $DefaultConfig =
'{
	"Config": {
	},
	"Description": {
	}
}';
*/
	private static $DefaultList =
'{
	"test": {
		"Func": "Test",
		"Args": []
	},
	"register": {
		"Func": "Register",
		"Args": ["mobile", "pw", "type"]
	},
	"register2": {
		"Func": "Register2",
		"Args": ["mobile", "pw", "type"]
	},
	"login": {
		"Func": "LogIn",
		"Args": ["mobile", "pw", "lng", "lat", "devid"]
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
		"Args": ["mobile", "smscode"]
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
	"uploadavatar": {
		"Func": "UploadAvatar",
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
	},
	"getuser": {
		"Func": "GetUser",
		"Args": ["mobile"]
	},
	"index": {
		"Func": "HomepageInfo",
		"Args": []
	},
	"ptflow": {
		"Func": "PatientFlow",
		"Args": ["center"]
	},
	"item": {
		"Func": "Item",
		"Args": ["n"]
	},
	"content": {
		"Func": "Content",
		"Args": ["aid"]
	},
	"like": {
		"Func": "LikeAnArticle",
		"Args": ["aid", "uid"]
	},
	"chksignin": {
		"Func": "CheckSignIn",
		"Args": ["uid"]
	},
	"signin": {
		"Func": "SignIn",
		"Args": ["uid"]
	},
	"devrepair": {
		"Func": "DeviceRepair",
		"Args": ["devid", "by", "report"]
	},
	"devrepairlist": {
		"Func": "DeviceRepairList",
		"Args": []
	},
	"devstat": {
		"Func": "DeviceStatistics",
		"Args": []
	},
	"stock": {
		"Func": "StockCorD",
		"Args": ["type"]
	},
	"getcredit": {
		"Func": "GetCredit",
		"Args": ["uid"]
	},
	"setcredit": {
		"Func": "SetCredit",
		"Args": ["uid","ruleid"]
	},
	"userlist": {
		"Func": "GetUserList",
		"Args": ["type"]
	},
	"doctorlist": {
		"Func": "GetDoctorList",
		"Args": []
	},
	"nurselist": {
		"Func": "GetNurseList",
		"Args": []
	},
	"patientlist": {
		"Func": "GetPatientList",
		"Args": []
	},
	"prehd": {
		"Func": "PreHD",
		"Args": ["op", "uid"]
	},
	"inhd": {
		"Func": "InHD",
		"Args": ["op", "uid"]
	},
	"posthd": {
		"Func": "PostHD",
		"Args": ["op", "uid"]
	},
	"hdadv": {
		"Func": "HDDoctorAdvice",
		"Args": ["op", "uid"]
	},
	"exreg": {
		"Func": "ExReg",
		"Args": ["name", "mobile"]
	}
}';

	public static function Register($pParamArray) {
		$serverinfo = array('errno' => 2000, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		$paramcnt = count($pParamArray);
		if (is_array($pParamArray) &&  $paramcnt >= 2) {
			if ($paramcnt === 2) {
				$mobile = $pParamArray[0];
				$pw = $pParamArray[1];
				$user = new User($mobile, $pw);
				$ret = $user->Register();
				$username = $ret['server'][Lib::$Config->InterfaceName->Data]['username'];
				$nickname = $ret['server'][Lib::$Config->InterfaceName->Data]['nickname'];
				if (!empty($username)) {
					//EasemobHelper::CreateUser($username, $pParamArray[1]);
					EasemobHelper::CreateUser($mobile, $pw);
					EasemobHelper::SetNickname($mobile, $nickname);
				}
			} else {
				//$doctor = new Doctor($pParamArray[0], $pParamArray[1]);
				//$ret = $doctor->Register();
				$ret = 'doctor registration';
				switch ($pParamArray[2]) {
				   case 'd':
						 echo "doctor";
						 break;
				   case 'n':
						 echo "nurse";
						 break;
				   case 'p':
						 echo "patient";
						 break;
				}

			}
		}
		return Utils::FormatReturningData($ret);
	}
	public static function Register2($pParamArray) {
		$serverinfo = array('errno' => 2000, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		$paramcnt = count($pParamArray);
		if (is_array($pParamArray) &&  $paramcnt === 3) {
			$mobile = $pParamArray[0];
			$pw = $pParamArray[1];
			$usertype = (int)($pParamArray[2]);
			if ($usertype < User::TYPE_DOCTOR || $usertype > User::TYPE_PATIENT) {
				$usertype = User::TYPE_DOCTOR;
			}
			$user = new User($mobile, $pw, $usertype);
			$ret = $user->Register();
			$username = $ret['server'][Lib::$Config->InterfaceName->Data]['username'];
			$nickname = $ret['server'][Lib::$Config->InterfaceName->Data]['nickname'];
			if (!empty($username)) {
				//EasemobHelper::CreateUser($username, $pParamArray[1]);
				EasemobHelper::CreateUser($mobile, $pw);
				EasemobHelper::SetNickname($mobile, $nickname);
			}			
			var_dump($user);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function LogIn($pParamArray) {
$logfile = 'D:/wtserver/tmp/login.log';
Utils::LogToFile($logfile, Utils::FormatReturningData($pParamArray));
		$argc = count($pParamArray);
Utils::LogToFile($logfile, "argc=$argc");
		if (is_array($pParamArray) && ($argc === 5)) {
			$mobile = $pParamArray[0];
			$pw = $pParamArray[1];
			$lng = $pParamArray[2];
			$lat = $pParamArray[3];
			$devid = $pParamArray[4];
			/*
			if ($argc === 3) {
				$user = new User($pParamArray[0], $pParamArray[1], $pParamArray[2]);
			} else {
				$user = new User($pParamArray[0], $pParamArray[1]);
			}*/
			//var_dump($pParamArray);
			$user = new User($mobile, $pw, $devid);
			$ret = $user->LogIn($lng, $lat, $devid);
		} else {
			$serverinfo = array('errno' => 2001, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
			$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
			$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		}
Utils::LogToFile($logfile, "final return:".Utils::FormatReturningData($ret));
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
			$serverinfo = array('errno' => 2000, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
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
			$serverinfo = array('errno' => 2000, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
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
			$serverinfo = array('errno' => 2000, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
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
			$serverinfo = array('errno' => 2000, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
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
		$ret = array( 'servertime' => Utils::GetTimeArray(microtime(true)));
		return Utils::FormatReturningData($ret);
	}

	public static function GetDBTime($pParamArray) {
		$db = Lib::DBInit();
		$result = $db->Query('select UNIX_TIMESTAMP();');
		Lib::DBTerm($db);

		$ret = array( 'dbtime' => Utils::GetTimeArray($result->fetch_array(MYSQLI_NUM)[0]));
		return Utils::FormatReturningData($ret);
	}

	public static function Test() {
		$params = explode('&', $_SERVER['QUERY_STRING']);
		$tester = new Tester(__CLASS__, 10);
		return Utils::FormatReturningData($tester->Test($params));
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
		$serverinfo = array('errno' => 2000, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
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

	public static function UploadAvatar($pParamArray) {
$logfile = 'D:/wtserver/tmp/uploadavatar.log';
Utils::LogToFile($logfile, Utils::FormatReturningData($pParamArray));
		
		$ret = false;
		$files = Utils::GetAllPostedFileInfo();

Utils::LogToFile($logfile, Utils::FormatReturningData($files));

		if (is_array($pParamArray) && count($pParamArray) === 2) {
			$mobile = $pParamArray[0];
			$sessionid = $pParamArray[1];
			$ret = User::IsLoggedIn($mobile, $sessionid);

Utils::LogToFile($logfile, 'IsLoggedIn:'.Utils::FormatReturningData($ret));
			if ($ret) {

				foreach ($files as $fileinfo) {
					$fm = new ImageFileManager($_SERVER['DOCUMENT_ROOT'], 'images/user',
									0, 0, null, Lib::$Config->ImageFileManager->Compression);
					$fm->EnableCompression(true);
					$fm->SetCompressionMode('Portrait');

					if (is_array($fileinfo['name'])) {
						$orgext = '.'.pathinfo($fileinfo['name'][0], PATHINFO_EXTENSION);
						$tmpfile = $fileinfo['tmp_name'][0];
					} else {
						$orgext = '.'.pathinfo($fileinfo['name'], PATHINFO_EXTENSION);
						$tmpfile = $fileinfo['tmp_name'];
					}
					$tmpfile_w_orgext = $tmpfile . $orgext;
					rename($tmpfile, $tmpfile_w_orgext);
					$hkey = '';
					$ret = $fm->SaveFile($tmpfile_w_orgext, null, true, $hkey);

					session_id($sessionid);
					@session_start();
					User::UpdateAvatar($_SESSION['UserID'], $hkey.$orgext);
					break; // handles only the first file posted
				}
			}
		}
Utils::LogToFile($logfile, 'ImageFileManager returned:'.Utils::FormatReturningData($ret));
Utils::LogToFile($logfile, 'ImageFileManager count:'.count($ret));
		if (count($ret) === 2) {
			//thumbnail
			$urllist = array_combine(array('original', 'thumbnail'),$ret); 
			$_SESSION['portrait'] = $urllist['thumbnail'];
Utils::LogToFile($logfile, 'urllist :'.count($urllist));
		}

Utils::LogToFile($logfile, 'final return :'.Utils::FormatReturningData(array('url' => $urllist)));
		return Utils::FormatReturningData(array('url' => $urllist));
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
		$serverinfo = array('errno' => 2008, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
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
		$serverinfo = array('errno' => 2008, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
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
		$serverinfo = array('errno' => 2008, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
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
		$serverinfo = array('errno' => 2008, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
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
	
	public static function GetUser($pParamArray) {
		$serverinfo = array('errno' => 2009, Lib::$Config->InterfaceName->Data => '', 'error' => 'Invalid request');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);

		if (is_array($pParamArray) && count($pParamArray) === 1) {
			$mobile = $pParamArray[0];
			$ret = User::GetUserInfo([$mobile], false, false);
		} else {
			// ?
		}
		return Utils::FormatReturningData($ret);
	}
////////////////////////////////////////////////////////////////
	public static function HomepageInfo($pParamArray) {
		/*
最外层加版本号
{banner:{num,url,params},item:{num,url,params}}

何键:
给出banner以及下面item的数量，各自图标的url，
我:
明白
何键:
banner 的params是跳转信息。
item的params是跳转信息以及文本文字
文本文字包含字体颜色得了
*/

/*
{
	"version": "1.0",
	"banner": {
		"url": "bannerUrl"
	},
	"service": {
		"txt": "serviceText",
		"url": "itemUrl",
		"imgUrl": "serviceImageUrl"
	},
	"item": {
		"txt": "itemText",
		"url": "itemUrl",
		"imgUrl": "itemImageUrl"
	}
}
*/
		$bannerBase = 'http://192.168.19.146/hvh/banner/';
		$serverBase = 'http://192.168.19.146/hvh/service/';
		$itemBase = 'http://192.168.19.146/hvh/v1/api/item?n=';
		

		$ver = '1.0'; //$ver = ??::GetVersion();
		$ret = array(
			'version' => $ver,
			'banner'=> array(
				'url' => array(
					$bannerBase.'banner_01.jpg',
					$bannerBase.'banner_02.jpg',
					$bannerBase.'banner_03.jpg'
				)
			),
			'service' => array(
				'txt' => array(
					'ServiceText_1',
					'ServiceText_2',
				),
				'url' => array(
					'serviceUrl_1',
					'serviceUrl_2',
				),
				'imgUrl' => array(
					$serverBase.'service_01.png',
					$serverBase.'service_02.png'
				)
			),
			'item' => array(
				'txt' => array(
					'营养治疗',
					'营养食谱',
					'心理教育',
					'疾病科普'
				),
				'url' => array(
					/*$itemBase.'1',
					$itemBase.'2',
					$itemBase.'3',
					$itemBase.'4'
					*/
					'1','2','3','4'
				),
				'imgUrl' => array(
					$serverBase.'service_03.png',
					$serverBase.'service_04.png',
					$serverBase.'service_05.png',
					$serverBase.'service_06.png'
				)
			)
		);
		return Utils::FormatReturningData($ret);
	}
	
	public static function Item($pParamArray) {
		$n = $pParamArray[0];
		$imgBase = 'http://192.168.19.146/hvh/bgimg/';
		$contentBase = 'http://192.168.19.146/hvh/v1/api/content?aid=';
		$sql = 'select am.`title`,DATE(am.`createTime`) as `time`, '
			."am.`writer`,concat('$imgBase',am.`imgurl`) as `imgUrl`,"
			//."concat('$contentBase', am.`ID`) as `txtUrl`, am.`avatar`,"
			.'am.`ID` as `txtUrl`, am.`avatar`,'
			.'am.`description`,'
			.'ac.`name` as `category`, `likes`'
			.' from `article_master` am, `article_category` ac'
			.' where am.`status`=1'
			." and am.`category`= ac.`ID`"
			." and am.`category`= $n"
			.' order by `createTime` desc;';

		$db = Lib::DBInit();
		$result = $db->Query($sql);
		Lib::DBTerm($db);
		
		$data = array();
		foreach ($result as $row) {
			array_push($data, $row);
		}
		$ret = array('list'=>$data);

		return Utils::FormatReturningData($ret);
	}
	public static function Content($pParamArray) {
		$n = $pParamArray[0];
		$ret = $n;

		$sql = 'select content'
			.' from `article_master`'
			.' where `status`=1'
			." and `ID`= $n;";

		$db = Lib::DBInit();
		$result = $db->Query($sql);
		Lib::DBTerm($db);

		foreach ($result as $row) {
			//array_push($data, $row);
			$ret = $row;
			break;
		}

		return Utils::FormatReturningData($ret);
	}
	public static function LikeAnArticle($pParamArray) {
		$aid = $pParamArray[0];
		$uid = $pParamArray[1];

		$lockTblW = 'lock table `%s` write';
		$lockTblR = 'lock table `%s` read';
		
		$db = Lib::DBInit();
		Lib::DBTerm($db);
		$ret = array(
			"likes" => 1
		);

		return Utils::FormatReturningData($ret);
	}

	public static function PatientFlow($pParamArray) {
		if (is_array($pParamArray) && count($pParamArray) === 1) {
/*
病人流转
每月{
总人数，
死亡，转院，临时，长期，各项人数
}
总共最近12个月，默认最近一个月
*/
			$cenid = $pParamArray[0];
			$ret = array(
				'center' => $cenid,
				'Month'=> array(
					array(
						'total' => 200,
						'decease' => 5,
						'trans' => 12,
						'temp' => 8,
						'permanent' => 175
					),
					array(
						'total' => 200,
						'decease' => 5,
						'trans' => 12,
						'temp' => 8,
						'permanent' => 175
					)
				)
			);
		} else {
			// ?
			$ret = "center required";
		}
		return Utils::FormatReturningData($ret);
	}
	public static function CheckSignIn($pParamArray) {
		$uid = $pParamArray[0];
		$usersign = new UserSign($uid);
		$ret = array(
			'lastsignin' => $usersign->GetLastSignIn(),
			'curtime' => time()
		);
		unset($usersign);
		return Utils::FormatReturningData($ret);
	}
	public static function SignIn($pParamArray) {
		$uid = $pParamArray[0];
		$usersign = new UserSign($uid);
		$ret = $usersign->SignIn();
		unset($usersign);
		return Utils::FormatReturningData($ret);
	}
	public static function DeviceRepair($pParamArray) {
		$devid = $pParamArray[0];
		$repairman = $pParamArray[1];
		$report = $pParamArray[2];

		$id = uuid::yacomb();
		$now = date('Y-m-d H:i:s');
		$sql = 'insert into `device_maintenance`(`ID`, `DeviceID`, `Repairman`,`RepairDate`, `Report`)'
			."values('$id', '$devid', '$repairman', '$now', '$report');";

		$db = Lib::DBInit();
		$db->autocommit(false);
		$db->begin_transaction();
		$db->Query($sql);
		$rollback = true;
		if ($db->affected_rows === 1) {
			$sql = "update `device` set `LastRepairDate`='$now' where `ID`='$devid';";
			$db->Query($sql);
			if ($db->affected_rows === 1) {
				$ret = $db->commit();
				$rollback = false;
			}
		} else {
			$rollback = false;
		}
		if ($rollback) {
			$db->rollback();
		}
		Lib::DBTerm($db);
		
		if ($ret) {
			$ret = array('sts'=>'ok');
		} else {
			$ret = array('sts'=>'err');
		}
		
		return Utils::FormatReturningData($ret);
	}
	public static function DeviceRepairList($pParamArray) {
		$db = Lib::DBInit();
		$sql = 'SELECT b.`ID` as `DevID`, b.`Name`, b.`Model`, b.`SerialNum`, a.`RepairDate`, a.`Report`,a.`Repairman` '
			. ' FROM `device_maintenance` a, `device` b WHERE a.`DeviceID` = b.`ID` order by b.`Name`;';
		$result = $db->Query($sql);
		Lib::DBTerm($db);

		$rootdata = array();
		$data1 = array();

		foreach ($result as $row) {
			array_push($rootdata, $row);
		}

		if ($ret) {
			$ret = array('sts'=>'ok');
		} else {
			$ret = array('sts'=>'err');
		}
		$ret = $rootdata;

		return Utils::FormatReturningData($ret);
	}

	public static function DeviceStatistics($pParamArray) {
		$db = Lib::DBInit();
		$sql = 'select `ID` as `DevID`,`SerialNum`, `Name`, `Brand`, `Model`, `LastRepairDate` from `device`;';
		$result = $db->Query($sql);
		Lib::DBTerm($db);

		$data = array();
		foreach ($result as $row) {
			array_push($data, $row);
		}

		if ($ret) {
			$ret = array('sts'=>'ok');
		} else {
			$ret = array('sts'=>'err');
		}
		$ret = $data;

		return Utils::FormatReturningData($ret);
	}
	public static function StockCorD($pParamArray) {
		$type = $pParamArray[0];

		return Utils::FormatReturningData($ret);
	}
	public static function GetCredit($pParamArray) {
		$uc = new UserCredit($pParamArray[0]);
		$ret = $uc->GetCredit(0);
		return Utils::FormatReturningData($ret);
	}
	public static function SetCredit($pParamArray) {
		$uc = new UserCredit($pParamArray[0]);
		$ret = $uc->SetCredit($pParamArray[1]);
		return Utils::FormatReturningData($ret);
	}
	public static function GetUserList($pParamArray) {
		$type = $pParamArray[0];
		if ($type < User::TYPE_DOCTOR || $type > User::TYPE_PATIENT) {
			$type = User::TYPE_DOCTOR;
		}
		$ret = User::GetList($type);
		return Utils::FormatReturningData($ret);
	}
	public static function GetDoctorList($pParamArray) {
		$ret = User::GetList(User::TYPE_DOCTOR);
		return Utils::FormatReturningData($ret);
	}
	public static function GetNurseList($pParamArray) {
		$ret = User::GetList(User::TYPE_NURSE);
		return Utils::FormatReturningData($ret);
	}
	public static function GetPatientList($pParamArray) {
		$ret = User::GetList(User::TYPE_PATIENT);
		return Utils::FormatReturningData($ret);
	}
	public static function PreHD($pParamArray) {
		$ret = PreHD::Do($pParamArray);
		return Utils::FormatReturningData($ret);
	}
	public static function ExReg($pParamArray) {
		//允许跨域访问
		header('Access-Control-Allow-Origin:*');
		header('Access-Control-Allow-Methods:POST');
		header('Access-Control-Allow-Headers:x-requested-with,content-type');

		$logfile = 'D:/wtserver/exreg.log';
		$name = $pParamArray[0];
		$mobile = $pParamArray[1];
		if (Utils::LogToFile($logfile, "$name,$mobile")) {
			$ret = array('sts' => 'ok');
		} else {
			$ret = array('sts' => 'ng');
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
				if (is_numeric($val)) {
					$args[$i] = $val;
				} else {
					if (!empty($val)) {
						$args[$i] = $val;
					}
				}
			}
		}

		$ret = self::$func($args);
		return $ret;
	}
/*
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
*/
	public static function GetList() {
		$list = null;
		$fn = __DIR__ . str_replace(__NAMESPACE__,'', __CLASS__).'List.json';
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
//Action::$Config = Action::GetConfig();
Action::$List = Action::GetList();
}// End of namespace
?>