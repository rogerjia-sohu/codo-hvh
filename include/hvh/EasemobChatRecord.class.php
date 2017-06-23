<?php
namespace hvh {

class EasemobChatRecord {

	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	private static $mChatRecordTableName = 'easemob_chat_record';
	private $mMsg_id;
	private $mTimestamp; // time() * 1000 + millisecond
	private $mDirection;
	private $mTo;
	private $mFrom;
	private $mChat_type;
	private $mPayload_ext;
	private $mPayload_from;
	private $mPayload_to;
	private $mBodies_type;

	private $mBodies_txt_msg ;
	private $mBodies_file_length;
	private $mBodies_filename;
	private $mBodies_secret;
	private $mBodies_size_height;
	private $mBodies_size_width;
	private $mBodies_url;
	private $mBodies_loc_addr;
	private $mBodies_loc_lat;
	private $mBodies_loc_lng;

	private $mBodies_av_length;
	private $mBodies_video_thumb;
	private $mBodies_video_thumb_secret;
	private $mStatus;
	private $mFileHashCode;
	private $mFileManager;

	public function __construct($pEntityArray) {
		if (!is_array($pEntityArray) || empty($pEntityArray['msg_id'])) {
			return;
		}

		$jsonrecord = json_decode(json_encode($pEntityArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
		$this->mMsg_id = $jsonrecord->msg_id;
		
		$this->mTimestamp = $jsonrecord->timestamp;
		$this->mDirection = $jsonrecord->direction;
		$this->mTo = $jsonrecord->to;
		$this->mFrom = $jsonrecord->from;
		$this->mChat_type = $jsonrecord->chat_type;

		//$this->mPayload_ext = ; // 扩展属性未使用，暂不支持

		$this->mPayload_from = $jsonrecord->payload->from;
		$this->mPayload_to = $jsonrecord->payload->to;
		
		$jsonbody = &$jsonrecord->payload->bodies[0];
		$this->mBodies_type = $jsonbody->type;

		$this->mStatus = 1;
		switch ($this->mBodies_type) {
			case 'txt':
				$this->mBodies_txt_msg = $jsonbody->msg;
				break;
			case 'loc';
				$this->mBodies_loc_addr = $jsonbody->addr;
				$this->mBodies_loc_lat = $jsonbody->lat;
				$this->mBodies_loc_lng = $jsonbody->lng;
				break;
			case 'img':
				$this->SetImageEntity($jsonbody);
				$this->mFileManager = new EasemobImageFileManager();
				break;
			case 'audio';
				$this->SetAudioEntity($jsonbody);
				$this->mFileManager = new EasemobAudioFileManager();
				break;
			case 'video';
				$this->SetVideoEntity($jsonbody);
				$this->mFileManager = new EasemobVideoFileManager();
				break;
			case 'file';
				$this->SetFileEntity($jsonbody);
				$this->mFileManager = new EasemobOtherFileManager();
				break;
			default:
				$this->mStatus = 0;
				break;
		}

		$this->mFileHashCode = '';// must set
		if ($this->mStatus === 1) {
			$this->GetAttachment();
		}
	}

	private function SetFileEntity($pJsonBodyEnity) {
		if (!is_object($pJsonBodyEnity)) {
			return false;
		}
		$this->mBodies_file_length = $pJsonBodyEnity->file_length;
		$this->mBodies_filename = $pJsonBodyEnity->filename;
		$this->mBodies_secret = $pJsonBodyEnity->secret;
		$this->mBodies_url = $pJsonBodyEnity->url;
		return true;
	}

	private function SetImageEntity($pJsonBodyEnity) {
		if (!is_object($pJsonBodyEnity)) {
			return false;
		}
		$this->SetFileEntity($pJsonBodyEnity);
		$this->mBodies_size_height = $pJsonBodyEnity->size->height;
		$this->mBodies_size_width = $pJsonBodyEnity->size->width;
		return true;
	}

	private function SetAudioEntity($pJsonBodyEnity) {
		if (!is_object($pJsonBodyEnity)) {
			return false;
		}
		$this->SetFileEntity($pJsonBodyEnity);
		$this->mBodies_av_length = $pJsonBodyEnity->length;
		return true;
	}

	private function SetVideoEntity($pJsonBodyEnity) {
		if (!is_object($pJsonBodyEnity)) {
			return false;
		}
		$this->SetImageEntity($pJsonBodyEnity);
		$this->mBodies_av_length = $pJsonBodyEnity->length;
		$this->mBodies_video_thumb = $pJsonBodyEnity->thumb;
		$this->mBodies_video_thumb_secret = $pJsonBodyEnity->thumb_secret;
		return true;
	}

	private function SetFileColVal(&$pCols, &$pVals) {
		$pCols .= ',`bodies_file_length`,`bodies_filename`,`bodies_secret`,
					`bodies_url`, `file_hashcode`';
		$pVals .= sprintf(',%u,"%s","%s","%s","%s"',
			$this->mBodies_file_length,$this->mBodies_filename,
			$this->mBodies_secret,$this->mBodies_url,$this->mFileHashCode);
	}

	private function SetImageColVal(&$pCols, &$pVals) {
		$this->SetFileColVal($pCols, $pVals);
	
		$pCols .= ',`bodies_size_height`,`bodies_size_width`';
		$pVals .= sprintf(',%u,%u',
			$this->mBodies_size_height, $this->mBodies_size_width);
	}
	
	private function SetAudioColVal(&$pCols, &$pVals) {
		$this->SetFileColVal($pCols, $pVals);
		$pCols .= ',`bodies_av_length`';
		$pVals .= sprintf(',%u',$this->mBodies_av_length);
	}

	private function SetVideoColVal(&$pCols, &$pVals) {
		$this->SetImageColVal($pCols, $pVals);

		$this->mBodies_av_length = $pJsonBodyEnity->length;
		$this->mBodies_video_thumb = $pJsonBodyEnity->thumb;
		$this->mBodies_video_thumb_secret = $pJsonBodyEnity->thumb_secret;
		
		
		$pCols .= ',`bodies_av_length`,`bodies_video_thumb`,`bodies_video_thumb_secret`';
		$pVals .= sprintf(',%u,"%s","%s"',
			$this->mBodies_av_length,
			$this->mBodies_video_thumb,
			$this->mBodies_video_thumb_secret);
	}

	private function GetAttachment() {
		if (empty($this->mBodies_url) || empty($this->mBodies_secret)
			|| !is_object($this->mFileManager)) {
			return;
		}
		$ret = $this->mFileManager->SaveFile($this->mBodies_url,
					pathinfo($this->mBodies_filename, PATHINFO_EXTENSION),
					true, $this->mFileHashCode, 'Easemob_chatlogger');
		return $ret;
	}

	public function StoreToDB() {
		if ($this->mStatus !== 1) {
			return false;
		}

		$sql_col_begin = 'insert into `'.self::$mChatRecordTableName.'`(';
		$sql_cols = '`msg_id`,`timestamp`,`direction`,`to`,`from`'
			.',`chat_type`,`payload_ext`,`payload_from`, `payload_to`,`bodies_type`';
		$sql_col_end = ') ';

		$sql_val_begin = 'values(';
		$sql_vals = sprintf('%s,%u,"%s","%s","%s",  "%s","%s","%s","%s","%s"',
			$this->mMsg_id, $this->mTimestamp, $this->mDirection, $this->mTo, $this->mFrom,
			$this->mChat_type, $this->mPayload_ext, $this->mPayload_from, $this->mPayload_to, $this->mBodies_type);			
		$sql_val_end = ');';


		switch ($this->mBodies_type) {
			case 'txt':
				$sql_cols .= ',`bodies_txt_msg`';
				$sql_vals .= ',"'.$this->mBodies_txt_msg.'"';
				break;
			case 'loc';
				$sql_cols .= ',`bodies_loc_addr`,`bodies_loc_lat`,`bodies_loc_lng`';
				$sql_vals .= sprintf(',"%s",%.6f,%.6f',
						$this->mBodies_loc_addr,$this->mBodies_loc_lat,$this->mBodies_loc_lng);
				break;
			case 'img':
				$this->SetImageColVal($sql_cols, $sql_vals);
				break;
			case 'audio';
				$this->SetAudioColVal($sql_cols, $sql_vals);
				break;
			case 'video';
				$this->SetVideoColVal($sql_cols, $sql_vals);
				break;
			case 'file';
				$this->SetFileColVal($sql_cols, $sql_vals);
				break;
			default:
				break;
		}

		$sql = sprintf('%s %s %s %s %s %s',
				$sql_col_begin, $sql_cols, $sql_col_end,  $sql_val_begin, $sql_vals, $sql_val_end);

		$db = Lib::DBInit();
		$db->query($sql);
		Lib::DBTerm($db);
		return true;
	}
	
	public static function GetOneFileUrl($pMsgID) {
		$ret = false;
		$db = Lib::DBInit();
		$sql = sprintf('select bodies_type,file_hashcode from %s where `msg_id`="%s";',
						self::$mChatRecordTableName, $pMsgID);
		$result = $db->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		Lib::DBTerm($db);

		if ($result->num_rows === 1) {
			switch ($row[0]) {// bodies_type
				case 'img':
					$filemgr = new EasemobImageFileManager();
					break;
				case 'audio';
					$filemgr = new EasemobAudioFileManager();
					break;
				case 'video';
					$filemgr = new EasemobVideoFileManager();
					break;
				case 'file';
					$filemgr = new EasemobOtherFileManager();
					break;
			}
			$ret = $filemgr->GetOneLocalFileUrl($row[1]);
		}

		return $ret;
	}
}
}// End of namespace
?>
