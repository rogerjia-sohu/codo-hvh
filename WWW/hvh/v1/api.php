<?php
require_once "hvh/hvh.class.php";
use hvh\{Action};

// $funckey must be the same as the rewritting rule in nginx.conf
$funckey = 'func';

if (property_exists(Action::$List, $_GET[$funckey])) {
	echo Action::ProcessRequest($funckey);
} else {
	echo 'Invalid api';
}
?>
