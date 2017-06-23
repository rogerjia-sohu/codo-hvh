<?php
namespace hvh {

//
class Order {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected $mID;
	protected $mUserID;
	protected $mDoctorID;
	protected $mServiceID;
	protected $mDescription;

	public function __construct($pUserID, $pDoctorID, $pServiceID, $pDescription) {
		// TODO:
		echo __CLASS__ .'::'.__FUNCTION__ . '<br>';

		$this->mID = $this->GenOrderID();
		$this->mUserID = $pUserID;
		$this->mDoctorID = $pDoctorID;
		$this->mServiceID = $pServiceID;
		$this->mDescription = $pDescription;
	}

	protected function GenOrderID() {
		$time_val = time();
		$uuid = uuid::yacomb();
//$uuid_v4 = uuid::v4raw();
//var_dump($uuid_v4);
		$orderid = sprintf('%08x-%08x', $time_val, crc32($uuid));
echo strftime('<br />%Y%m%d%H%M%S<br />', hexdec(substr($orderid, 0, 8)));
		return $orderid;
		// C01-5684781-2387224 
	}
}
}// End of namespace
?>