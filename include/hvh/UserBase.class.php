<?php
namespace hvh {

require_once 'hvh/uuid.class.php';

abstract class UserBase {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected static $LoginPrefix = 'ulogin_';
	protected $mID;
	protected $mMobileNum;
////////////////////////////////
	protected $mName;
	protected $mGender;
	protected $mBirthDate;
////////////////////////////////
	protected $mRegTime;
	protected $mPassword;
	protected $mPaidMembership;
	protected $mWxCode;
////////////////////////////////
	protected $mDBTableName;

	abstract public function Register();
	abstract public function LogIn();

	public function __construct($pMobile = '', $pPW = '', $pWxCode = '', $pFilename) {
		//print_r('entering >>> '.__METHOD__.'<br>');
		$this->mID = uuid::yacomb();
		$this->mRegTime = date('Y-m-d H:i:s');
		$this->mMobileNum = $pMobile;
		$this->mPassword = $pPW;
		$this->mWxCode = $pWxCode;
		$this->SetDBTableName($pFilename);
		//print_r('exiting <<< '.__METHOD__.'<br>');
	}

	protected function SetDBTableName($pFilename) {
		$this->mDBTableName = explode('.', basename($pFilename))[0];
	}
	
	public static function IsLoggedIn($pMobile, $pSessionID) {
		$redis = Lib::RedisInit();
		$userdata = $redis->hgetall(self::$LoginPrefix . md5($pMobile));
		Lib::RedisTerm($redis);
		$iphash = $userdata['iphash'];
		$ret = ($pSessionID === $userdata['sessionid'])
				&& ($iphash === md5($_SERVER['REMOTE_ADDR']));
		return $ret;
	}
}
}// End of namespace
?>