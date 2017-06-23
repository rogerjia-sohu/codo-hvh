<?php
namespace hvh {

class IDCard {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	private static $WD = [7,9,10,5,8,4,2,1,6,3];
	private static $CHKDIGIT = [1,0,'x',9,8,7,6,5,4,3,2];

	public static function CheckNumber($pID) {
		$ret = false;
		if (preg_match('/^\d{17}[0-9x]{1}$/i', $pID)) {
			$wdlen = count(self::$WD);
			for ($i = 0; $i < 17; $i++) {
				$s += (int)($pID[$i] * self::$WD[$i % $wdlen]);
			}
			$ret = (strcasecmp($pID[17], self::$CHKDIGIT[$s % 11]) === 0);
		}
		$d = substr($pID, 6, 8);
		self::CheckBirthDate($d);
		return $ret;
	}
	
	private static function CheckBirthDate($pBirthDate) {
		$ret = false;

		$byear = (int)substr($pBirthDate, 0, 4);
		$bmonth = (int)substr($pBirthDate, 4, 2);
		$bday = (int)substr($pBirthDate, 6, 2);
		
		$year = (int)date('Y');
		$month = (int)date('m');
		$day = (int)date('d');

		if ($byear === $year) {
			if ($bmonth === $month) {
				if ($bday < $day) {
					$ret = true;
				}
			} else if ($bmonth < $month) {
				// TODO: checks days in a month
				$ret = true;
			}
		} else if ($byear < $year) {
			// TODO: checks months in a year and days in a month
			$ret = true;
		}
		return $ret;
	}
}
}// End of namespace
?>