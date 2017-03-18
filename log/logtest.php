<?php 
require_once('filelog.class.php');
$msg = "hello world";
$instance = FileLog::getInstance('api')->info($msg);
$instance = FileLog::getInstance('api')->debug($msg);
$instance = FileLog::getInstance('api')->WARN($msg);
$instance = FileLog::getInstance('api')->error($msg);

