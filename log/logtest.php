<?php 
require_once('Log.class.php');
$msg = "hello world";
$instance = Log::Init('api')->DEBUG($msg);
var_dump($instance);