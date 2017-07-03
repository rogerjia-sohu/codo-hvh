<?php
namespace hvh {
class HttpStatus {

	public static function Out($pCode) {
		$code = (int)$pCode;
		$serverinfo = array('errno' => $code, Lib::$Config->InterfaceName->Data => '', 'error' => 'unknown error');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');

		$statusinfo = array(
// 1xx (Informational): The request was received, continuing process
			100 => 'Continue',
			101 => 'Switching Protocols',
			102 => 'Processing',
// 2xx (Successful): The request was successfully received, understood, and accepted
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			207 => 'Multi-Status',
			208 => 'Already Reported',
			226 => 'IM Used',
// 3xx (Redirection): Further action needs to be taken in order to complete the request
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => 'Switch Proxy',
			307 => 'Temporary Redirect',
			308 => 'Permanent Redirect',
// 4xx (Client Error): The request contains bad syntax or cannot be fulfilled
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Payload Too Large',
			414 => 'URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Range Not Satisfiable',
			417 => 'Expectation Failed',
			418 => 'I\'m a teapot',
			421 => 'Misdirected Request',
			422 => 'Unprocessable Entity',
			423 => 'Locked',
			424 => 'Failed Dependency',
			426 => 'Upgrade Required',
			428 => 'Precondition Required',
			429 => 'Too Many Requests',
			431 => 'Request Header Fields Too Large',
			451 => 'Unavailable For Legal Reasons',
// 5xx (Server Error): The server failed to fulfill an apparently valid request
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			506 => 'Variant Also Negotiates',
			507 => 'Insufficient Storage',
			508 => 'Loop Detected',
			510 => 'Not Extended',
			511 => 'Network Authentication Required',
// Unofficial codes
			// IIS expansions
			440 => 'Login Time-out',
			449 => 'Retry With',
			451 => '',
			// nginx expansions
			444 => 'No Response',
			495 => 'SSL Certificate Error',
			496 => 'SSL Certificate Required',
			497 => 'HTTP Request Sent to HTTPS Port',
			499 => 'Client Closed Request'
		);

		if (array_key_exists($code, $statusinfo)) {
			$serverinfo['error'] = $statusinfo[$code];
		}

		$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		return Utils::FormatReturningData($ret);
	}
}
}// End of namespace
?>