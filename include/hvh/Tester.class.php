<?php
namespace hvh {

class Tester {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected $mSender;
	protected $mCoe;
	protected $mArgv;

	public function __construct($pSender, $pCoe = 1) {
		$this->mSender = $pSender;
		$this->mCoe = ($pCoe >= 1)? $pCoe: 1;
		return $ret;
	}

	public function Test(&$pArgv) {
		// Holds any testing/debugging code
		$this->InitArgv($pArgv);
		$argv = &$this->mArgv;

		$maxtime = ini_get('max_execution_time');
		ini_set('max_execution_time', $maxtime * $this->mCoe);

		// TODO
		echo 'Adding test code in ' . __METHOD__ . ' ('. __FILE__ . ':'.__LINE__ .')<br>';
		//$ret = Utils::FormatReturningData($this->mArgv);

$hdjsonLong =
'
{
	"preHD": {
		"name": "John Smith",
		"caseNo": "cn123abc",
		"date": "2017-07-20",
		"hdTime": "3",
		"hdDevType": 0,
		"sickbedNo": 1,
		"hdTube": 2,
		"preWeight": "80",
		"dryWeight": "80",
		"dehydration": "78",
		"estDehydration": "78",
		"preTemperature": "36.8",
		"startSBP": "80,120",
		"startLBP": "78,118",
		"bleeding": 0,
		"fever": 0,
		"skin": "normal",
		"internalFistulaInfo": "normal",
		"armNeedling": "L | R",
		"vein": "internalJugularVein | femoralVein",
		"passageMode": "temp | lt",
		"vesselType": "cvc | internalFistulaCatheter | graftVessels",
		"punctureCount": 1,
		"punctureNeedle": 0,
		"dressingChange": true,
		"remarks": "what a large json this is!"
	},
	"inHD": {
		"dateBetween": "14, 17",
		"BP": "75, 115",
		"pulse": 85,
		"bloodFluxion": "1.234",
		"intravenous": "90",
		"hdPressure": "100",
		"UFR": "123",
		"hdTemperature": "30.5",
		"conductivity": "1.5",
		"hdValence": 1,
		"heparinNumber": "1.234",
		"symptom": "abc",
		"amylaceum": "6.5",
		"NS": "1.2",
		"metathesis": "1.5",
		"remarks": "I am in HD..."
	},
	"postHD": {
		"postWeight": "88.8",
		"postTemperature": "36.3",
		"realDehydration": "2.5",
		"endSitPress": "85, 125",
		"endLainPress": "80, 120",
		"hdTubeFreezing": "0.85",
		"remarks": "Now, HD done."
	},
	"medicalAdvice": {
		"anticoagulation": "UFH | LMWH | NH",
		"priming": "what is priming?",
		"NS": 100,
		"initialDose": 25,
		"maintenanceDose": 75,
		"concentrationOfCalciumPotassium": "0.15",
		"dialysisMethods": "which method do you prefer?",
		"medicalAdviceList": {
			"time": "2017-07-20",
			"medicalAdvice": "Drink more water",
			"doc": "John"
		},
		"illnessState": "???"
	}
}
';

		$hd = json_decode($hdjsonLong);
		var_dump(json_encode($hd));
		
		ini_set('max_execution_time', $maxtime);
		return $ret;
	}

	protected function InitArgv(&$pArgv) {
		$cnt = 0;
		foreach ($pArgv as $arg) {
			$kv = explode('=', $arg);
			$k[$cnt] = $kv[0];
			$v[$cnt] = $kv[1];
			$cnt++;
		}
		$this->mArgv = array_combine($k, $v);
	}
}
}// End of namespace
?>