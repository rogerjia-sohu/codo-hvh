<?php
namespace hvh {

require_once 'hvh/uuid.class.php';
require_once 'hvh/iPageable.class.php';

class Hospital implements iPageable{
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	protected $mID;// uuid
	protected $mName;
	protected $mRank;
	protected $mCityID;
	protected $mAddress;
	protected $mBriefIntro;
	protected $mDepartments;
	protected $mSortKey1;
	protected $mState;
////////////////////////////////
	protected $mDBTableName;
	protected $mRedisHKey;
	protected $mRedisTTL;

	public function __construct() {
		$this->mID = uuid::yacomb();
		//$this->mRegTime = date('Y-m-d H:i:s');
		$this->mDBTableName = explode('.', basename(__FILE__))[0];
		$this->mRedisHKey = 'page_'.__CLASS__;
		$this->mRedisTTL = 600;
	}

	public function GetDBTableName() { return $this->mDBTableName; }

	public function GetRadisHKey() { return $this->mRedisHKey; }

	public function GetRadisTTL() { return $this->mRedisTTL; }

	public function GetCount() {
		$db = Lib::DBInit();
		$result = $db->query(sprintf('select count(1) from %s where `Status`=1;', $this->mDBTableName));
		$row = $result->fetch_array();
		Lib::DBTerm($db);
		return (count($row) > 0)? (int)$row[0] : 0;
	}

	public function GetDataList($pParamArray) {
//医院信息调取的 包括医院名称/级别/地址/简介/图片/科目/
//api参考：http://XXX.XXX.XXX/v1/hospital?start={%}&count={%}
// 回传还需要一个total 如果没有这参数默认count为20 start为0
//{count: start: total: subjects:{ name: addr: summary: img:{s: m: l:} departments:{XXX,XXX,XXX} } 这样就ok

		$serverinfo = array('errno' => 0, Lib::$Config->InterfaceName->Data => '', 'error' => '');
		$dbinfo = array('errno' => 0, 'sqlstate' => '00000', 'error' => '');

		$strfmt = "select `Name` as `name`,"
				."`Rank` as `rank`,"
				."`Address` as `addr`,"
				."`BriefIntro` as `summary`,"
				."`ID` as `img`,"
				."`Departments` as `departments` "
				." from `%s` "
				." where `Status`=1 "
				."order by `SortKey1`;";
		$sql = sprintf($strfmt, $this->mDBTableName);

		$db = Lib::DBInit();
		$result = $db->query($sql);
		$infolist = array();
		$imgpath = 'http://'.$_SERVER['SERVER_ADDR'].'/images/hospital/';
		foreach ($result as $row) {
			$myimgpath = sprintf('%s%s/',$imgpath, $row['img']);
			$row['img']=array(
				's' => $myimgpath.'s.jpg',
				'm' => $myimgpath.'m.jpg',
				'l' => $myimgpath.'l.jpg',
			);
			$depts = explode(':', $row['departments']);
			$row['departments'] = $depts;
			array_push($infolist, $row);
		}
		Lib::DBTerm($db);
		$serverinfo[Lib::$Config->InterfaceName->Data] = $infolist;
		$ret = array('server' => $serverinfo, 'db' => $dbinfo);
		return $ret;
	}
}
}// End of namespace
?>