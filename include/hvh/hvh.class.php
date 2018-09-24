<?php
namespace hvh {

require_once 'hvh/Action.class.php';
require_once 'hvh/Connection.class.php';
require_once 'hvh/ConnectionPool.class.php';
require_once 'hvh/Const.class.php';
require_once 'hvh/CUtf8_PY.class.php';
require_once 'hvh/DBSearchEngine.class.php';
require_once 'hvh/DBUtils.class.php';
require_once 'hvh/Easemob.class.php';
require_once 'hvh/EasemobChatRecord.class.php';
require_once 'hvh/EasemobFileManager.class.php';
require_once 'hvh/EasemobHelper.class.php';
require_once 'hvh/HashedFileManager.class.php';
require_once 'hvh/ImageCompressor.class.php';
require_once 'hvh/ImageFileManager.class.php';
require_once 'hvh/HJSms.class.php';
require_once 'hvh/HJSmsPool.class.php'; // 短信网关
require_once 'hvh/Hospital.class.php';
require_once 'hvh/HospitalControl.class.php';
require_once 'hvh/HttpStatus.class.php';
require_once 'hvh/IDCard.class.php';
require_once 'hvh/Order.class.php';
require_once 'hvh/PageManager.class.php';
require_once 'hvh/Pool.class.php';
require_once 'hvh/PreHD.class.php';
require_once 'hvh/Redis.class.php';
require_once 'hvh/RedisPool.class.php';
require_once 'hvh/RedisSMSCode.class.php';
require_once 'hvh/Silk2AmrFileManager.class.php';
require_once 'hvh/Tester.class.php';
require_once 'hvh/UserBase.class.php';
require_once 'hvh/User.class.php';
require_once 'hvh/UserCredit.class.php'; // 用户积分
require_once 'hvh/UserSign.class.php'; // 用户签到
require_once 'hvh/Utils.class.php';
require_once 'hvh/wx.class.php'; // 微信小程序

class Lib {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public static $Config;
	private static $DefaultConfig =
'{
	"Config": {
		"Global": {
			"ReturningFormat": "json",
			"JSON": {
				"EncOptions": 320
			}
		},
		"InterfaceName": {
			"Server": "server",
			"ErrNo": "errno",
			"Data": "info",
			"Error": "error",
			"DB": "db",
			"SqlState": "sqlstate"
		},
		"Redis": {
			"Host": "localhost",
			"PoolCapacity": 32,
			"Retry": 3,
			"DelayMilliSecond": 100
		},
		"DB": {
			"Host": "localhost",
			"Charset": "utf8",
			"DBName": "hvh_v1",
			"PoolCapacity": 32,
			"Retry": 3,
			"DelayMilliSecond": 100
		},
		"User": {
			"DefaultPortraitID": "1c95ca00b4ede83f63610ad9e8f1011c"
		},
		"HJSms": {
			"PoolCapacity": 3,
			"Retry": 3,
			"DelayMilliSecond": 100,
			"User": "XC10079",
			"Pswd": "Zhaode2016",
			"VeriCode": "rz1lbv6v6g0x",
			"TPL_0001": "0001"
		},
		"ImageFileManager": {
			"Root": "DOCUMENT_ROOT",
			"BaseDir": "images",
			"HashFunc": 0,
			"DirNameLength": 2,
			"DBTableName": "image_md5",
			"Compression": {
				"Enabled": 1,
				"Use": "Default",
				"Default": {
					"Percent": 0.75,
					"Quality": 0.75,
					"Filters": 0,
					"KeepOriginal": 1,
					"OriginalPrefix": "original-"
				},
				"Portrait": {
					"MaxSide": 200,
					"Quality": 1.0,
					"Filters": 0,
					"KeepOriginal": 1,
					"OriginalPrefix": "original-"
				}
			}
		},
		"Easemob": {
			"Server": {
				"Use": "Release",
				"Release": {
					"client_id": "YXA6MQB9UEBLEeeT4e-RGvor9g",
					"client_secret": "YXA6-iLpppJAVLiHqjg0MWaT-9qpmps",
					"org_name": "1122170524178152",
					"app_name": "mktest"
				},
				"Debug": {
					"client_id": "YXA6HnX6kD9jEeedIBcdb29etA",
					"client_secret": "YXA6FxIDnM3Nuo2Nu3lMhtyor2OvMRQ",
					"org_name": "1129170523178885",
					"app_name": "testapp20170523"
				}
			},
			"ChatRecordExecTime": 600,
			"ChatRecordLogDir": "",
			"ImageFileManager": {
				"Root": "DOCUMENT_ROOT",
				"BaseDir": "easemob/image",
				"HashFunc": 0,
				"DirNameLength": 2,
				"DBTableName": "easemob_image",
				"Compression": {
					"Enabled": 1,
					"Use": "Default",
					"Default": {
						"Percent": 0.75,
						"Quality": 0.75,
						"Filters": 0,
						"KeepOriginal": 1,
						"OriginalPrefix": "original-"
					},
					"Portrait": {
						"MaxSide": 200,
						"Quality": 1.0,
						"Filters": 0,
						"KeepOriginal": 1,
						"OriginalPrefix": "original-"
					}
				}
			},
			"AudioFileManager": {
				"Root": "DOCUMENT_ROOT",
				"BaseDir": "easemob/audio",
				"HashFunc": 0,
				"DirNameLength": 2,
				"DBTableName": "easemob_audio"
			},
			"VideoFileManager": {
				"Root": "DOCUMENT_ROOT",
				"BaseDir": "easemob/video",
				"HashFunc": 0,
				"DirNameLength": 2,
				"DBTableName": "easemob_video"
			},
			"OtherFileManager": {
				"Root": "DOCUMENT_ROOT",
				"BaseDir": "easemob/other",
				"HashFunc": 0,
				"DirNameLength": 2,
				"DBTableName": "easemob_other"
			}
		},
		"Silk2Amr": {
			"Engine": {
				"SilkDecoder": {
					"Bin": "D:/WTServer/bin/silk2amr/silk_v3_decoder.exe",
					"ParamFmtList1": "%s %s.pcm >nul 2>&1"
				},
				"ffmpeg": {
					"Bin": "D:/WTServer/bin/silk2amr/ffmpeg.exe",
					"ParamFmtList1": "-y -f s16le -ar 24.4k -ac 1 -i %s.pcm %s.wav",
					"ParamFmtList2": "-y -i %s.wav -ar 8000 -ab 12.2k -ac 1 %s"
				}
			},
			"FileManager": {
				"Root": "DOCUMENT_ROOT",
				"BaseDir": "hvh/silk2amr",
				"HashFunc": 0,
				"DirNameLength": 2,
				"DBTableName": "silk2amr"
			}
		}
	},
	"Hints": {
		"Global": {
			"ReturningFormat": "返回数据的格式{ json | array }",
			"JSON": {
				"EncOptions": "调用json_encode函数时使用的参数"
			}
		},
		"Redis": {
			"Host": "Redis主机地址",
			"PoolCapacity": "Redis连接池容量，不能大于redis.conf文件中maxclients指定的值",
			"Retry": "获取Redis连接时重试的次数",
			"DelayMilliSecond": "每次重试之前等待的毫秒数"
		},
		"DB": {
			"Host": "数据库主机地址",
			"Charset": "所用的字符集",
			"DBName": "数据库名",
			"PoolCapacity": "数据库连接池容量",
			"Retry": "获取数据库连接时重试的次数",
			"DelayMilliSecond": "每次重试之前等待的毫秒数"
		},
		"User": {
			"DefaultPortraitID": "用户默认头像的ID"
		},
		"HJSms": {
			"PoolCapacity": "短信网关池容量",
			"Retry": "获取短信网关时重试的次数",
			"DelayMilliSecond": "每次重试前等待的毫秒数",
			"User": "短信网关的用户名",
			"Pswd": "短信网关的密码",
			"VeriCode": "身份校验码",
			"TPL_0001": "短信模板编号"
		},
		"ImageFileManager": {
			"Root": "图片文件在SERVER上的根目录{DOCUMENT_ROOT}",
			"BaseDir": "Root目录的下级目录",
			"HashFunc": "图片文件的hash方法{ 0=>HASH_MD5 | 1=>HASH_SHA1}",
			"DirNameLength": "每个目录名的字符长度n，值越大每个目录内的文件越多。{ 1 | 2 | 3 | 4 } files = 16^n",
			"DBTableName": "image_md5"
		}
	}
}';

	public static function DBInit() {
		try {
			$db = ConnectionPool::GetInstance(__NAMESPACE__ . '\Connection',
					self::$Config->DB->PoolCapacity)->GetObj();
		} catch (\ErrorException $e) {
			$db = null;
		}
		return $db;
	}

	public static function DBTerm(&$pDB) {
		if (is_a($pDB, __NAMESPACE__ . '\Connection')) {
			ConnectionPool::GetInstance(__NAMESPACE__ . '\Connection',
					self::$Config->DB->PoolCapacity)->ReleaseObj($pDB);
		}
	}

	public static function RedisInit() {
		try {
			$redis = RedisPool::GetInstance(__NAMESPACE__ . '\Redis',
					self::$Config->Redis->PoolCapacity)->GetObj();
		} catch (\ErrorException $e) {
			$redis = null;
		}
		return $redis;
	}

	public static function RedisTerm(&$pRedis) {
		if (is_a($pRedis, __NAMESPACE__ . '\Redis')) {
			RedisPool::GetInstance(__NAMESPACE__ . '\Redis',
					self::$Config->Redis->PoolCapacity)->ReleaseObj($pRedis);
		}
	}

	public static function HJSmsInit() {
		try {
			$sms = HJSmsPool::GetInstance(__NAMESPACE__ . '\HJSms',
					self::$Config->HJSms->PoolCapacity)->GetObj();
		} catch (\ErrorException $e) {
			$sms = null;
		}
		return $sms;
	}

	public static function HJSmsTerm(&$pHJSms) {
		if (is_a($pHJSms, __NAMESPACE__ . '\HJSms')) {
			HJSmsPool::GetInstance(__NAMESPACE__ . '\HJSms',
					self::$Config->HJSms->PoolCapacity)->ReleaseObj($pHJSms);
		}
	}

	public static function GetConfig() {
		$cfg = null;
		$fn = __DIR__ . str_replace(__NAMESPACE__.'\\', DIRECTORY_SEPARATOR, __CLASS__) .'.json';
		if (file_exists($fn)) {
			$cfg = json_decode(file_get_contents($fn))->Config;
		}
		if (is_null($cfg)) {
			$cfg = json_decode(self::$DefaultConfig)->Config;
			file_put_contents($fn, self::$DefaultConfig);
		}
		return $cfg;
	}
}
Lib::$Config = Lib::GetConfig();
}// End of namespace
?>
