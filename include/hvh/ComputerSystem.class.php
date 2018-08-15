<?php
namespace hvh {

class ComputerSystem {
	public const MAJOR_VER = 1;
	public const MINOR_VER = 0;
	public const RELEASE_VER = 0;

	public static function Version($pType = 0) {
		return Utils::GetVersion(__CLASS__, __FILE__, $pType);
	}

	public static function fsv0uuid() {
		// file system volume 0(/boot on sda1) uuid
		if (substr(PHP_OS, 0,3) == "WIN") {
			exec("@for /f \"tokens=2 delims={}\" %a in ('fsutil volume list  ^| find \"?\"') do @echo %a && exit", $ret);
		} else {
			exec("cat /etc/fstab | grep ^[UUID] | awk '{print $1}' | awk -F=  '{print $2}'", $ret);
		}
		return $ret[0];
	}
}
}// End of namespace
?>