<?php
namespace hvh {

class WeiXin {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	private const WX_HTTP_URL =
		'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=';
	private $mURL;
	
	public function __construct($pToken = '') {
		$this->mURL = self::WX_HTTP_URL.$pToken;
		//echo $this->mURL;
	}

	public function TextMsg($pToUser, $pFromUser, $pCreateTime, $pMsgType, $pContent) {
		
	}

	public function ImageMsg() {
		
	}
}
}// End of namespace
?>