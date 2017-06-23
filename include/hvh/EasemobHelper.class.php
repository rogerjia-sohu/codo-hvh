<?php
namespace hvh {

class EasemobHelper{

	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	private static $mOptions = null;

	public static function GetOptions() {
		$type = Lib::$Config->Easemob->Server->Use;
		self::$mOptions = array(
			'client_id' => Lib::$Config->Easemob->Server->$type->client_id,
			'client_secret' => Lib::$Config->Easemob->Server->$type->client_secret,
			'org_name' => Lib::$Config->Easemob->Server->$type->org_name,
			'app_name' => Lib::$Config->Easemob->Server->$type->app_name
		);
	}

	private static function CreateEasemob() {
		if (is_null(self::$mOptions)) {
			self::GetOptions();
		}
		return (new Easemob(self::$mOptions));
	}

	private static function SaveChatRecordToDB($pRecordArray) {
		$cnt = 0;
		if (is_array($pRecordArray)) {
			foreach ($pRecordArray as $record) {
				if (self::SaveOneChatRecordToDB($record)) {
					$cnt++;
				}
			}
		}
		return $cnt;
	}

	private static function SaveOneChatRecordToDB($pRecord) {
		$ret = false;
		$recordentity = new EasemobChatRecord($pRecord);
		$ret = $recordentity->StoreToDB();
		return $ret;
	}

	public static function GetChatRecord($pTime10) {
		$ret = 'retry later';

		$easemob = self::CreateEasemob();
		$chatlogarr = $easemob->getChatRecord30($pTime10);

		$chatdata = $chatlogarr['data'];
		if (is_array($chatdata)) {
			$totalrecord = array();
			foreach ($chatdata as $gzfile) {
				$filelink = $gzfile['url'];
				$chatlog = gzdecode(file_get_contents($filelink));
				//file_put_contents($pTime10, $chatlog, FILE_APPEND);
				$chatrecord = explode("\n", $chatlog);
				foreach ($chatrecord as $record) {
					if (!empty($record)) {
						array_push($totalrecord, json_decode($record, true));
					}
				}
			}
			$ret = $totalrecord;

			$newtimelimit = 600; // seconds
			$oldtimelimit = ini_get('max_execution_time');
			if ($oldtimelimit < $newtimelimit) {
				ini_set('max_execution_time', $newtimelimit);
			}
			$cnt = self::SaveChatRecordToDB($totalrecord);
			ini_set('max_execution_time', $oldtimelimit);
		}

		return $ret;
	}

	public static function GetOneFileUrl($pMsgID) {
		return EasemobChatRecord::GetOneFileUrl($pMsgID);
	}

	public static function IsOnline($pUsername) {
		$easemob = self::CreateEasemob();
		$rawdata = $easemob->isOnline($pUsername);
		$ret = $rawdata['data'];
		if (!@array_key_exists($pUsername, $ret)) {
			$ret = array( $pUsername => $rawdata['error_description']);
		}
		return Utils::FormatReturningData($ret);
	}

	public static function CreateUser($pUsername, $pPassword) {
		$easemob = self::CreateEasemob();
		return Utils::FormatReturningData($easemob->createUser($pUsername, $pPassword));
	}

	public static function GetUser($pUsername) {
		$easemob = self::CreateEasemob();
		return Utils::FormatReturningData($easemob->getUser($pUsername));
	}

	public static function DeleteUser($pUsername) {
		$easemob = self::CreateEasemob();
		return Utils::FormatReturningData($easemob->deleteUser($pUsername));
	}

	public static function GetFriend($pUsername) {
		$easemob = self::CreateEasemob();
		return Utils::FormatReturningData($easemob->showFriends($pUsername));
	}
	
	public static function SetNickname($pUsername, $pNickname) {
		$easemob = self::CreateEasemob();
		return Utils::FormatReturningData($easemob->editNickname($pUsername, $pNickname));
	}
}
}// End of namespace
?>