<?php
namespace hvh {

class HJSms {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	private static $SM_SERVER_URL =
		'http://121.43.104.172:8030/service/httpService/httpInterface.do';
	private $mSrvParam;

	public function __construct() {
		$this->mSrvParam = array();
		$this->mSrvParam['username'] = Lib::$Config->HJSms->User;		// 账号
		$this->mSrvParam['password'] = Lib::$Config->HJSms->Pswd;		// 密码
		$this->mSrvParam['veryCode'] = Lib::$Config->HJSms->VeriCode;	// 通讯认证Key
		$this->mSrvParam['tempid'] =
			sprintf('%s-%s',
					Lib::$Config->HJSms->User, Lib::$Config->HJSms->TPL_0001); // 模板编号
	}

	public function Balance() {
		$this->mSrvParam['method'] = 'getAmount';
		$res = Utils::request_post(self::$SM_SERVER_URL, $this->mSrvParam);
		return Utils::xml_to_array($res);
	}

	public function TextMsgNormal($pMobile, $pContent, $pCode = 'utf-8' /* or gbk */) {
		$this->mSrvParam['method'] = 'sendMsg';
		$this->mSrvParam['mobile'] = $pMobile;
		$this->mSrvParam['content']= $pContent;
		$this->mSrvParam['msgtype']= '1';       // 1-普通短信，2-模板短信
		$this->mSrvParam['code']   = $pCode;   // utf-8,gbk
		$res = Utils::request_post(self::$SM_SERVER_URL, $this->mSrvParam);
		return Utils::xml_to_array($res);
	}

	public function TextMsgTemplate($pMobile, $pContent, $pCode = 'utf-8' /* or gbk */) {
		$this->mSrvParam['method'] = 'sendMsg';
		$this->mSrvParam['mobile'] = $pMobile;
		$this->mSrvParam['content']= '@1@='.$pContent;
		$this->mSrvParam['msgtype']= '2';       // 1-普通短信，2-模板短信
		//$this->mSrvParam['tempid'] = 'XC10079-0001'; // 模板编号
		$this->mSrvParam['tempid'] =
			sprintf('%s-%s',
					Lib::$Config->HJSms->User, Lib::$Config->HJSms->TPL_0001); // 模板编号
		$this->mSrvParam['code']   = $pCode;   // utf-8,gbk
		$res = Utils::request_post(self::$SM_SERVER_URL, $this->mSrvParam);
		return Utils::xml_to_array($res);
	}

	public function QueryReport() {
		$this->mSrvParam['method'] = 'queryReport';	
		$res = Utils::request_post(self::$SM_SERVER_URL, $this->mSrvParam);
		return Utils::xml_to_array($res);
	}	
}
}// End of namespace
?>