<?php
/**
 * 规范：
 * 1. 日志目录统一放到/data/logs/
 * 2. 日志按日期分目录,便于归档
 * 3. 当天日志按controller id 分不同文件,
 * 例如： /data/logs/redbo/webapi/2016-04-08/site.log
 * 4. 文件大小要自动备份 文件默认最大值5M
 * 
 * 思路:
 * 给定内容,写入文件(fopen,fwrite..)
 * 如果文件大于>1M,重新写一份
 * 传给我一个内容
 * 判断当前日志的大小
 *  如果>1M,备份
 *  否则,写入
*/
class FileLog
{

    private static  $_instance = [];
     private static $filePath;
    private $handler = null;
    private $level   = 15;
    private $fileDir;
    private $filename;
    private $fileMaxSize;//日志文件最大为5M
   
    private $initOk;

    /**
     * log类初始化
     * @param string  $filename 日志文件名|不含文件后缀
     * @param string  $dir      日志文件目录
     * @param integer $level     
     */
    protected function __construct($filename, $dir,$maxSize,$level)
    {
        $this->filename = $filename;
        if(!strrpos($dir,date("Y-m-d")))
            $this->fileDir = rtrim($dir,'/').'/'.date("Y-m-d");
        else
            $this->fileDir = $dir;
        $this->fileMaxSize = (int) $maxSize;
        $this->level = $level;
        $this->initOk = $this->initDir();
        umask(0000);
        self::$filePath = $this->_getLogFilePath($this->fileDir,$this->filename);
        if(!$this->_isExist( self::$filePath))
        {
            if(!$this->createDir($this->fileDir))  
            {  
                #echo("创建目录失败!");  
            }  
            if(!$this->_createLogFile( self::$filePath)){  
                #echo("创建文件失败!");  
            }  
        }
        // 文件备份
        $this->_isBack( self::$filePath );
    }

     /**
     * 获取日志类实例
     * @param string  $filename 日志文件名|不含文件后缀
     * @param string  $dir      日志文件目录
     * @param integer $level     
     */
    public static function getInstance($filename,$dir = '/home/logs/Api',$maxSize = 5, $level = 2)
    {
        $dot_offset = strrpos($filename,'.');
        if($dot_offset !== false)
            $filename = substr($filename,0,$dot_offset);
        if(!isset(self::$_instance[$filename]))
        {
            self::$_instance[$filename] = new self($filename, $dir, $maxSize, $level);
            self::$_instance[$filename]->_initHandler(self::$filePath);; 
        }
        return self::$_instance[$filename];
    }

    private function _initHandler($path)
    {
        $this->handler = @fopen($path,"a+");  
    }

    public function DEBUG($msg)
    {
        self::$_instance[$this->filename]->write(1,$msg);
    }

    public  function WARN($msg)
    {
        self::$_instance[$this->filename]->write(4,$msg);
    }

    public function ERROR($msg)
    {
        $debugInfo = debug_backtrace();
        $stack = "[";
        foreach ($debugInfo as $key => $val) 
        {
            if(array_key_exists('file', $val))
            {
                $stack .= 'file:' . $val['file'];
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
        $stack = ltrim($stack,',');
        $stack .= ']';
        self::$_instance[$this->filename]->write(8,$stack . $msg);
    }

    public function INFO($msg)
    {
        self::$_instance[$this->filename]->write(2,$msg);
    }

    public function write($level, $msg)
    {
        if($this->initOk ==false)
            return;
        $msg = '[' . date('Y-m-d H:i:s').']['.$this->_getLevelStr($level).'] '. $msg . "\n";
        fwrite($this->handler, $msg, 4096);
    }

    private function _getLevelStr($level)
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

    /**
     * 目录初始化
     */
    protected function initDir()
    {

        if(is_dir($this->fileDir) === false)
        {
            if(!$this->createDir($this->fileDir))
            {
                //throw new Exception("目录创建失败", -1);
                return false;
            }     
        }
        return true;
    }

    /**
     * 拼接文件路径
     * @param  string $dir  文件目录
     * @param  string $file 文件名
     * @return string 文件全路径名
     */
    private function _getLogFilePath($dir,$file)
    {
        $file = $file .'.log';
        return rtrim($dir,'/') .'/'.$file;
    }

    /**
     * 目录创建
     * @param  string $dir 目录名称
     * @return bool 
     */
    protected function createDir($dir)
    {
        return is_dir($dir) or ($this->createDir(dirname($dir)) and @mkdir($dir, 0777));
    }

    /**
     * 判断文件是否存在
     */
    private function _isExist($path)
    {
        return file_exists($path);
    }

     /**
     * 创建日志文件 | 需要做备份处理
     * @param  string $path 文件处理
     * @return [type]       [description]
     */
    private  function _createLogFile($path)
    {
        if(file_exists($path))
        {
            return true;
        }
        return touch($path);
    }

    
    /**
     * 日志备份
     * @param  string  $path 需要备份的文件
     * @return bool
     */
    private function _isBack($path)
    {
        $fileSize = filesize($path);
        if($fileSize >= ($this->fileMaxSize * 1024 * 1024) ) 
        {
            $bakpath = str_replace('.log', '', $path);
            $bakpath = $bakpath . date("ymdhis") . '_bak.log';
            return rename($path,$bakpath);
        }
        return false;
    }

    // public function __destruct()
    // {
    //     @fclose($this->$handler);
    // }
}
