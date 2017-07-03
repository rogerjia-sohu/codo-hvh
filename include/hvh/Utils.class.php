<?php
namespace hvh {

class Utils {
	private const MAJOR_VER = 1;
	private const MINOR_VER = 0;
	private const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public static function GetVersion($pClass, $pLibFile, $pType = 0 /* */) {
		$fmt = array(
				'%s (%s) V%d.%d.%d-%s',/* plain text */
				'<font style="color:navy">%s</font> <font style="color:blue">(%s)</font> V%d.%d.%d-%s',
				'{Class: "%s", File: "%s", Version: "%d.%d.%d", Updated: "%s"}'
		);
		return sprintf($fmt[$pType%count($fmt)], $pClass, basename($pLibFile),
				$pClass::MAJOR_VER, $pClass::MINOR_VER, $pClass::RELEASE_VER,
				date('Ymd', filemtime($pLibFile)));
	}

	public static function GetHttpValue($pName) {
		$val = $_POST[$pName];
		if (is_null($val)) {
			$val = $_GET[$pName];
		}
		return $val;
	}

	public static function HasHttpValue($pName) {
		return !empty(self::GetHttpValue($pName));
	}

	public static function HasHttpParam($pName) {
		return (isset($_GET[$pName]) || isset($_POST[$pName]));
	}

	public static function GetHttpXmlObj() {
		return simplexml_load_string(file_get_contents('php://input'));
	}

	public static function GetHttpJsonObj() {
		return json_decode(file_get_contents('php://input'));
	}

	public static function FormatReturningData($pArrayData) {
		if (Lib::$Config->Global->ReturningFormat == 'json') {
			return json_encode($pArrayData, Lib::$Config->Global->JSON->EncOptions);
		}
		return $pArrayData;
	}

	public static function GetPostedFileInfo($pClientFilelistName) {
		return $_FILES[$pClientFilelistName];
	}
	
	public static function GetAllPostedFileInfo() {
		return $_FILES;
	}
	
	public static function ClientDownloadFile($pFileUrl) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($pFileUrl).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($pFileUrl));
		$ret = readfile($pFileUrl);
		return $ret;
	}

	public static function GetTimeArray($pTimestamp) {
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
////////////////////////////////////////////////////////////////
	/**
	 * 模拟post进行url请求
	 * @param string $url
	 * @param array $post_data
	 */
	public static function request_post($url = '', $post_data = array()) {
		if (empty($url) || empty($post_data)) {
			return false;
		}

		$o = "";
		foreach ( $post_data as $k => $v )
		{
			$o.= "$k=" . urlencode( $v ). "&" ;
		}
		$post_data = substr($o,0,-1);

		$postUrl = $url;
		$curlPost = $post_data;
		$ch = curl_init();//初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = curl_exec($ch);//运行curl
		curl_close($ch);

		return $data;
	}

	// XML格式转数组格式
	public static function xml_to_array( $xml ) {
		$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches)) {
			$count = count($matches[0]);
			for($i = 0; $i < $count; $i++) {
				$subxml= $matches[2][$i];
				$key = $matches[1][$i];
				if(preg_match( $reg, $subxml )) {
					$arr[$key] = self::xml_to_array( $subxml );
				} else {
					$arr[$key] = $subxml;
				}
			}
		}
		return $arr;
	}

	// 页面显示数组格式，用于调试
	public static function echo_xmlarr($res) {
		$res = self::xml_to_array($res);
		echo '<pre>';
		print_r($res);
		echo '</pre>';
	}
}
}// End of namespace
?>