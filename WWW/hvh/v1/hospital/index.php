<?php
require_once "hvh/hvh.class.php";
use hvh\{PageManager, Hospital, Utils};
$start = Utils::GetHttpValue('start') or $start = 0;
$count = Utils::GetHttpValue('count') or $count = 20;
echo Utils::FormatReturningData(PageManager::Page([new Hospital(), $start, $count]));
?>
