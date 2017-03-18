<?php

// 工厂模式
class factory
{
    public static $_services = [];
    /**
     * 生产对象
     * @param  string $class 类名
     * @return object|bool
     */
    public static function getInstance($class)
    {
        // 加载生产类
        $className = ucfirst($class).'.Service';
        if(!isset(self::$_services))
        {
            if(file_exists($className.'.class.php'))
            {
                require_once $className.'.class.php';
                return new $className();
            }
        }
        else
        {
            return $_services[$className];
        }
    }
}
