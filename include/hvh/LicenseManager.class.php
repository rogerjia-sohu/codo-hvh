<?php
namespace hvh {

class LicenseManager {
	 const MAJOR_VER = 1;
	 const MINOR_VER = 0;
	 const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	 const TableName = 'license';
	 const HistoryTableName = 'license_history';
	 const DevTableName = 'device';

	 const OP_ADD = 1;
	 const OP_REMOVE = 2;
	 const OP_UPDATE = 3;

	protected $mSender;
	protected $mCoe;
	protected $mArgv;

	public function __construct($pSender, $pCoe = 1) {
		$this->mSender = $pSender;
		$this->mCoe = ($pCoe >= 1)? $pCoe: 1;
		return $ret;
	}

	public static function CheckByDevSN($pDevSN) {
		$strfmt = "select `b`.`Name`,`b`.`IP_addr`,`a`.`Id`,`a`.`Type_id`,`a`.`Dev_sn`,`a`.`Max_gateway`,`a`.`Cur_gateway`,"
			."`a`.`Max_ipc`,`a`.`Cur_ipc`,`a`.`Issue_date`,`a`.`Expiry_date`,`a`.`Last_operator`,"
			." `a`.`Last_operation`,`a`.`data1`,`a`.`data2`,`a`.`data3` "
			. "from `%s` a, `%s` b "
			. "where `a`.`Dev_sn` = `b`.`Dev_sn` and `a`.`Dev_sn` = '%s' and `a`.`Status` = 1";
		$sql = sprintf($strfmt, self::TableName, self::DevTableName, $pDevSN);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);

		$liclist = [];
		foreach ($result as $row) {
			array_push($liclist, $row);
		}
		self::Validate($liclist);

		return $liclist;
	}
	
	public static function CheckByIPv4($pIPv4) {
		$strfmt = "select `b`.`Name`,`b`.`IP_addr`,`a`.`Id`,`a`.`Type_id`,`a`.`Dev_sn`,`a`.`Max_gateway`,`a`.`Cur_gateway`,"
			."`a`.`Max_ipc`,`a`.`Cur_ipc`,`a`.`Issue_date`,`a`.`Expiry_date`,`a`.`Last_operator`,"
			." `a`.`Last_operation`,`a`.`data1`,`a`.`data2`,`a`.`data3` "
			. "from `%s` a, `%s` b "
			. "where `a`.`Dev_sn` = `b`.`Dev_sn` and `b`.`IP_addr` = '%s' and `a`.`Status` = 1";
		$sql = sprintf($strfmt, self::TableName, self::DevTableName, $pIPv4);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);

		$liclist = [];
		foreach ($result as $row) {
			array_push($liclist, $row);
		}
		self::Validate($liclist);

		return $liclist;
	}
	
	public static function GetLicenseList() {
		$strfmt = "select `b`.`Name`,`b`.`IP_addr`,`a`.`Id`,`a`.`Type_id`,`a`.`Dev_sn`,`a`.`Max_gateway`,`a`.`Cur_gateway`,"
			."`a`.`Max_ipc`,`a`.`Cur_ipc`,`a`.`Issue_date`,`a`.`Expiry_date`,`a`.`Last_operator`,"
			." `a`.`Last_operation`,`a`.`data1`,`a`.`data2`,`a`.`data3` "
			. "from `%s` a, `%s` b "
			. "where `a`.`Dev_sn` = `b`.`Dev_sn` and `a`.`Status` = 1";
		$sql = sprintf($strfmt, self::TableName, self::DevTableName);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);

		$liclist = [];
		foreach ($result as $row) {
			array_push($liclist, $row);
		}
		self::Validate($liclist);

		return $liclist;
	}

	public static function Import($pLicFile) {
$licstr="H4sIAAAAAAAACsWTXW/bNhSG/8qg20QoefgdoBdybG8yQhnJnATSOhgkRdmSLTuQ"
."7cZSsf8+Jukwt/fDCBIQeV6dLz7841s09l+Xh110ExEmPWWgYkuRiinhPJbeoph6"
."4qySJQPGo+to0b/4ZV1GN/g60ua8XJmjfzV9dMM+9vWLCzaOrqP0cDj5ZRnswTsg"
."LGMUpvgF4RuEwgzOJueXuusvNOpCIz80aYgV+YoKZrmJASMXMyNozI0RMeZWVECV"
."QUgG7e2p+zch9LF/Tyh835nDcdnuy7rqj3X7U04YvcUjEH3X7V98Z477Lqi6/f74"
."43G9372XPzZHg4PC0VKAdQRKTLmTVVV6qRzzsnKEUmsqbKyw3nEqGeOeK0eJdVJ6"
."p4Tl/i3omysIrvLhYZMNszofdF+MJyhrNS3aYlMsViwfnrbzX4tGD/cob6etfp7W"
."Gcy2+ZCj+fgRZ+0jzJ810jBr5uN1ON+QvCm2en11d5v8M16yXk+y1SRJR3r0bNPR"
."ht6PRqem3X75dLaTnWxlsW1RWz8cH4r0VNLOp3OMBR1+O9/1tMvWD8lK3M6TL59e"
."R/nwVe7cWb2mJ30a2af3CJ8/fy+IvF0cMiRcUVmR0BPOARijSPpKUoGZ4IC9gsoQ"
."CCYGWHkW+mYEIuDBK+qr4Or3ozmeDqHjf11f4Mq4kJc4wk84ogscCfyXNIJ0Ii6h"
."krGplLKOgrXS/G80ElVabAwFpICHZyvAWMDMOlzxkrqQtlCEGBDeI0uUtVAyxCps"
."ueTOWnFBox62m7yZrvPFfa/Hmz5r1pts4fr8Oe314ilQOm2zNtAIKeQLx/SQrXVT"
."bovFqA7/1nkzC/oEF00gtVlBDrM6O1/SuB+yxZwcxqbPugSyLgXd3CI0fkzSnZ4m"
."SHfJq14l+22RhpXox+Sq7OursX4H7YIz7irPufRMeG5KSpkVpBScV0QibgCHBviK"
."UAuhdiUJoSVIHMhTRvKqwv4Hzv78Gzm5Z+4YBQAA";
		//$licstr = file_get_contents($pLicFile);
		$licarr = self::DecodeLicense($licstr);
		$t = count($licarr);
		$c = 0;
		foreach($licarr as $lic) {
			$c += self::ImportOne($lic);
		}
		return $c;
	}

	public static function Validate(&$pA) {
		$newpa = [];
		foreach ($pA as $a) {
			self::ValidateOne($a);
			array_push($newpa, $a);
		}
		$pA = $newpa;
	}
	
	protected static function ValidateOne(&$pA) {
		$ret = 0;
		$a = array_values($pA);
		$v = sprintf("%s;%s;%s;%s;%s;%s",$a[4],$a[3],$a[5],$a[7],$a[9],$a[10]);
		$d1 = hash("sha256", $v);
		$d2 = base64_encode($d1.gzencode($v));
		$d3 = hash("sha256", $d2);

		if (($d1 === $a[13] && $d2 === $a[14] & $d3 === $a[15])) {
			self::Validate_s2($pA);
		} else {
			$c = base64_decode($a[14]);
			$d1 = substr($c, 0, 64);
			$k = gzdecode(substr($c, 64));
			$ka = explode(";", $k);
			$dk = hash("sha256", $k);

			if ($d1 === $dk) {
				$pA["data1"] = $d1;
				$pA["data3"] = hash("sha256", $a[14]);
				$pA["Dev_sn"] = $ka[0];
				$pA["Type_id"] = $ka[1];
				$pA["Max_gateway"] = $ka[2];
				$pA["Max_ipc"] = $ka[3];
				$pA["Issue_date"] = $ka[4];
				$pA["Expiry_date"] = $ka[5];
				self::Validate_s2($pA);
			} else {
				$ret = 1000;
			}
		}
		return $ret;
	}
	
	protected static function Validate_s2(&$pA) {
		$dev = DeviceManager::GetDevice($pA["IP_addr"])[0];
		switch ($dev["Type_id"]) {
			case 1: // 管理平台
				$gwlist = DeviceManager::GetDeviceList($dev["Id"]);
				$curgw = count($gwlist);
				$pA["Cur_gateway"] = $curgw;
			case 2: // 网关
				if (empty($gwlist)) {
					$gwlist = DeviceManager::GetDeviceList($dev["Id"]);
				}
				$ipclist = [];
				foreach ($gwlist as $gw) {
					$ipclist_1 = DeviceManager::GetDeviceList($gw["Id"]);
					$ipclist += $ipclist_1;
				}
				$curipc = count($ipclist);
				$pA["Cur_ipc"] = $curipc;
		}

		$strfmt = "update `%s` set "
		."`Type_id`='%d',`Dev_sn`='%s',`Max_gateway`='%d',`Cur_gateway`='%d',`Max_ipc`='%d',"
		."`Cur_ipc`='%d',`Issue_date`='%s',`Expiry_date`='%s',`Last_operator`='licmgr',"
		." `Last_operation`='%d',`data1`='%s',`data3`='%s' "
		. "where `Id` = '%s'";
		$sql = sprintf($strfmt, self::TableName, 
			$pA["Type_id"], $pA["Dev_sn"], $pA["Max_gateway"], $curgw, $pA["Max_ipc"],
			$curipc, $pA["Issue_date"], $pA["Expiry_date"],
			self::OP_UPDATE, $pA["data1"], $pA["data3"], $pA["Id"]);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		Lib::DBTerm($db);
	}

	protected static function DecodeLicense($pLicStr) {
		$r = ["\r\n", "\n", "\r"];
		$lic = gzdecode(base64_decode(str_replace($r, "", $pLicStr)));
		return json_decode($lic, true);
	}
	
	protected static function ImportOne($pLic) {
		$k = "`". implode("`,`", array_keys($pLic)) . "`";
		$v = "'". implode("','", array_values($pLic)) . "'";
		$strfmt = "insert into `%s`(%s) values(%s)";
		$sql = sprintf($strfmt, self::TableName, $k, $v);
		$db = Lib::DBInit();
		$db->query($sql);
		$rowcnt = $db->affected_rows;
		Lib::DBTerm($db);
		return $rowcnt;
	}
}
}// End of namespace
?>