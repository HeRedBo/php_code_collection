<?php
require_once './log.php';

$logHandler = new CLogFileHandler('./log/'.date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
$log::warn('warn info');

try {
   
    throw new Exception("Error Processing Request", 1);
    $m =  10 / 0;
    echo $m;
} 
catch (Exception $e) 
{
    $log::error($e->getMessage());
}