<?php
namespace hvh {

class LicenseHost {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected const TableName = 'license';
	protected const HistoryTableName = 'license_history';
	protected const OP_ADD = 1;
	protected const OP_REMOVE = 2;
	protected const OP_UPDATE = 3;

	protected $mSender;
	protected $mCoe;
	protected $mArgv;

	public function __construct($pSender, $pCoe = 1) {
		$this->mSender = $pSender;
		$this->mCoe = ($pCoe >= 1)? $pCoe: 1;
		return $ret;
	}

	public static function GenerateBySN($pArrDevSnType, $pStartDate, $pValidMonths) {
		$lic = [];
		foreach ($pArrDevSnType as $dev) {
			$dev[count($dev)] = $pStartDate;
			$dev[count($dev)] = date("Y-m-d h:m:s", strtotime("+$pValidMonths month", strtotime($pStartDate)));
			self::GenerateOne($dev);
			array_push($lic, $dev);
		}

		$licstr = self::EncodeLicense($lic, 64);

		header("Content-type: application/octet-stream");
		header("Accept-Ranges: bytes");
		header("Accept-Length: " . strlen($licstr));
		header("Content-Disposition: attachment; filename=license.txt");
		echo $licstr;
	}

	public static function GenerateByFile($pFile, $pStartDate, $pValidMonths, $pMaxGateway, $pMaxIPC) {
		
		return $devlist;
	}
	
	protected static function GenerateOne(&$pDevInfo) {
		$keys = ["Dev_sn", "Type_id", "Max_gateway", "Max_ipc", "Issue_date", "Expiry_date"];
		$v = implode(";", $pDevInfo);
		$d1 = hash("sha256", $v);
		$d2 = base64_encode($d1.gzencode($v));
		$d3 = hash("sha256", $d2);
		$pDevInfo = array_combine($keys, $pDevInfo);
		$pDevInfo["Id"] = uuid::yacomb2();
		$pDevInfo["Cur_gateway"] = 0;
		$pDevInfo["Cur_ipc"] = 0;
		$pDevInfo["Last_modifytime"] = date("Y-m-d h:m:s");
		$pDevInfo["Last_operator"] = "root";
		$pDevInfo["Last_operation"] = self::OP_ADD;
		$pDevInfo["Data1"] = $d1;
		$pDevInfo["Data2"] = $d2;
		$pDevInfo["Data3"] = $d3;
		$pDevInfo["Status"] = 1;

		return;
	}
	
	protected static function EncodeLicense($pLicArr, $pLineLen) {
		$result = [];
		$b64 = base64_encode(gzencode(json_encode($pLicArr)));
		$l = strlen($b64);
		$p = 0;
		if ($pLineLen > 0) {
			while ($p < $l) {
				array_push($result, substr($b64, $p, $pLineLen));
				$p += $pLineLen;
			}
		} else {
			return $b64;
		}
		return implode("\r\n", $result);
	}
}
}// End of namespace
?>