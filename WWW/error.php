<?php
require_once 'hvh/hvh.class.php';
use hvh\{HttpStatus,Utils};

$c = (int)Utils::GetHttpValue('c');
echo HttpStatus::Out($c);
?>