<?php
namespace hvh {

class PageManager {
// SMALL scale data paging under 100,000 rows
// NOT suitable for paging large scale data exceeding 100,000 rows
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	private const PM_IF_NAME = 'iPageable';

	public static function Page($pParamArray) {
		if ($pParamArray[0] instanceof iPageable) {
			 $obj = $pParamArray[0];
		} else {
			throw new \ErrorException ('Need a instance which must implement the "'.self::PM_IF_NAME.'" interface'); 
		}

		$start = $pParamArray[1] or $start = 0;
		$count = $pParamArray[2] or $count = 20;

		$redis = Lib::RedisInit();
		$total = $redis->hget($obj->GetRadisHKey(), 'total');
		Lib::RedisTerm($redis);
		if (empty($total)) {
			self::LoadPageFromObjToRedis($obj, $start, $count, $total);
		}

		$datalist = self::PageFromRadis($obj, $start, $count, $total);
		$ret = ['page' => [
						'count' => (int)$count,
						'start' => (int)$start,
						'total' => (int)$total],
				'subjects' => $datalist];
		return $ret;
	}

	private static function LoadPageFromObjToRedis($pObj, $pStart, &$pCount, &$pTotal) {
		$pTotal = $pObj->GetCount();
		$hlist = $pObj->GetDataList([$pStart, $pCount])['server']['data'];

		if ($pCount > $pTotal) {
			$pCount = $pTotal;
		}

		$harray = ['total' => $pTotal];
		for ($i = 0; $i < $pTotal; $i++) {
			array_push($harray, json_encode($hlist[$i]));
		}

		$key = $pObj->GetRadisHKey();
		$redis = Lib::RedisInit();
		$ret = $redis->multi()
			->hmset($key, $harray)
			->expire($key, $pObj->GetRadisTTL())
			->exec();
		Lib::RedisTerm($redis);

		return $ret;
	}

	private static function PageFromRadis($pObj, $pStart, &$pCount, $pTotal) {
		$cnt = $pStart + $pCount;
		if ($cnt > $pTotal) {
			$cnt = $pTotal;
		}

		$infokey = [];
		for ($i = $pStart; $i < $cnt; $i++) {
			array_push($infokey, (int)$i);
		}

		$pCount = count($infokey);
		if ($pCount > 0) {
			$redis = Lib::RedisInit();
			$infolist = $redis->hmget($pObj->GetRadisHKey(), $infokey);
			$redis->expire($pObj->GetRadisHKey(), $pObj->GetRadisTTL());
			Lib::RedisTerm($redis);

			$finalinfolist = [];
			for ($i = $pStart; $i < $cnt; $i++) {
				array_push($finalinfolist, json_decode($infolist[$i]));
			}
		}
		return $finalinfolist;
	}
}
}// End of namespace
?>