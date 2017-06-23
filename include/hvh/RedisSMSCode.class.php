<?php
namespace hvh {

class RedisSMSCode {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public static function GenCode($pMobile, $pDigit = 4, $pTTL = 600, $pMaxHits = 3) {
		if ($pDigit < 4) { $pDigit = 4; }
		if ($pTTL <= 0) { $pTTL = 600; }
		if ($pMaxHits < 0) {
			$pMaxHits = 1;
		} else if ($pMaxHits ==0 || $pMaxHits > 3) {
			$pMaxHits = 3;
		}

		$result = array(
				'mobile' => $pMobile,
				'smscode' => '',
				'ttl' => $pTTL,
				'maxhits' => $pMaxHits
		);

		if (!empty($pMobile)) {
			$fmt = sprintf('%%0%dd', $pDigit);
			$smscode = sprintf($fmt, mt_rand(0, pow(10, $pDigit)-1));
			$result['smscode'] = $smscode;

			$key = 'smscode_'.md5($pMobile);
			$data = array('code' => $smscode, 'hits' => 0, 'maxhits' => $pMaxHits);
			
			$redis = Lib::RedisInit();
			$redis->multi()
				->hmset($key, $data)
				->expire($key, $pTTL)
				->exec();
			Lib::RedisTerm($redis);
		}
		return $result;
	}

	public static function CheckCode($pMobile, $pCode) {
		$key = 'smscode_'.md5($pMobile);

		$redis = Lib::RedisInit();
		$data = $redis->hgetall($key);
		if (empty($data)) {
			return false;
		}
		$data['hits']++;
		$maxhits = $data['maxhits'];

		$ret = ($data['code'] === $pCode);
		if ($ret || $data['hits'] >= $data['maxhits']) {
			$redis->delete($key);
		} else {
			$redis->hset($key, 'hits', $data['hits']);
		}
		Lib::RedisTerm($redis);
		return $ret;
	}
}
}// End of namespace
?>