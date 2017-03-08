<?php
/**
 * 规范：
 * 1. 日志目录统一放到/data/logs/
 * 2. 日志按日期分目录,便于归档
 * 3. 当天日志按controller id 分不同文件,
 * 例如： /data/logs/redbo/webapi/2016-04-08/site.log
 * 
 * 思路:
 * 给定内容,写入文件(fopen,fwrite..)
 * 如果文件大于>1M,重新写一份
 * 传给我一个内容
 * 判断当前日志的大小
 *  如果>1M,备份
 *  否则,写入
*/
class Log
{
    private static $handler = null;
    private static $level   = 15;
    private static $filePath;
    private static $filename;
    private static $fileMaxSize;//日志文件最大为5M
    private static $initOk;
    private static  $instance = null;
    private function __construct(){}
    private function __clone(){}

    /**
     * log类初始化
     * @param string  $filename 日志文件名|不含文件后缀
     * @param string  $dir      日志文件目录
     * @param integer $level     
     */
    public static function Init($filename,$dir = '/home/logs/redbo/webapi', $maxSize =1, $level = 15)
    {
        $dot_offset = strrpos($filename,'.');
        if($dot_offset !== false)
            self::$filename = substr($filename,0,$dot_offset);
        else 
            self::$filename = $filename;
        if(!strrpos($dir,date("Y-m-d")))
            self::$filePath = rtrim($dir,'/').'/'.date("Y-m-d");
        else
            self::$filePath = $dir;

        self::$fileMaxSize  = (int)$maxSize;
        self::$level        = (int)$level;
        self::$initOk       = self::_InitDir();
        umask(0000);
        $path = self::_getLogFilePath(self::$filePath,self::$filename);
        if(!self::_isExist($path))
        {
            if(!self::_createDir(self::$filePath))  
            {  
                #echo("创建目录失败!");  
            }  
            if(!self::_createLogFile($path)){  
                #echo("创建文件失败!");  
            }  
        }
        
        if(!self::$instance instanceof self)
        {
            self::$instance = new self();
            self::$instance->_initHandler($path);
        }
        return self::$instance;
    }

    private function _initHandler($path)
    {
        self::$handler = @fopen($path,"a+");  
    }

    private static function _isExist($path)
    {
        self::_isBack($path);
        return file_exists($path);
    }

    public static function DEBUG($msg)
    {
        self::$instance->write(1,$msg);
    }

    public static function WARN($msg)
    {
        self::$instance->write(4,$msg);
    }

    public static function ERROR($msg)
    {
        $debugInfo = debug_backtrace();
        $stack = "[";
        foreach ($debugInfo as $key => $val) 
        {
            if(array_key_exists('file', $val))
            {
                $stack .= ',file:' . $val['file'];
            }

            if(array_key_exists('line', $val))
            {
                $stack .= ',line:' .$val['line'];
            }

            if(array_key_exists('function', $val))
            {
                $stack .= ',function:' .$val['function'];
            }
        }
        $stack .= ']';
        self::$instance->write(8,$stack . $msg);
    }

    public static function INFO($msg)
    {
        self::$instance->write(2,$msg);
    }

    /**
     * 创建日志文件 | 需要做备份处理
     * @param  string $path 文件处理
     * @return [type]       [description]
     */
    private static function _createLogFile($path)
    {
        if(file_exists($path))
        {
            return true;
        }
        return touch($path);
    }

    public function write($level, $msg)
    {
        if(($level & self::$level) == $level)
        {
            $msg = '[' . date('Y-m-d H:i:s').']['.self::_getLevelStr($level).'] '. $msg . "\n";
            fwrite(self::$handler, $msg, 4096);
        }
    }

    private static function _getLevelStr($level)
    {
        switch ($level) 
        {
            case 1:
                return 'debug';
                break;
            case 2:
                return 'info';
                break;
            case 4:
                return 'warn';
                break;
            case 8:
                return 'error';
                break;
            default:
                # code...
                break;
        }
    }

    public function __destruct()
    {
        @fclose(self::$handle);
    }
   
    /**
     * 日志备份
     * @param  string  $path 需要备份的文件
     * @return bool
     */
    private static function _isBack($path)
    {
        $fileSize = filesize($path);
        if($fileSize >= (self::$fileMaxSize * 1024 * 1024) ) 
        {
            $bakpath = str_replace('.log', '', $path);
            $bakpath = $bakpath . date("ymdhis") . '_bak.log';
            return rename($path,$bakpath);
        }
        return false;
    }

    /**
     * 拼接文件路径
     * @param  string $dir  文件目录
     * @param  string $file 文件名
     * @return string 文件全路径名
     */
    private static function _getLogFilePath($dir,$file)
    {
        $file = $file .'.log';
        return rtrim($dir,'/') .'/'.$file;
    }
    /**
     * 目录初始化
     */
    private static function _Initdir()
    {
        if(is_dir(self::$filePath) === false)
        {
            if(!self::_createDir(self::$filePath))
            {
                //throw new Exception("目录创建失败", -1);
                return false;
            }
        }
        return true;
    }

    /**
     * 目录创建
     * @param  string $dir 目录名称
     * @return bool 
     */
    private static function _createDir($dir)
    {
        return is_dir($dir) or (self::_createDir(dirname($dir)) and @mkdir($dir, 0777));  
    }
}

