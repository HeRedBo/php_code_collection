<?php
/**
 * service 工厂类 用来获取指定的service 对象
 * yii 中定义sevice基类 用于数据的其他service 的载入
 */
class ServiceFactory
{
    public static $_services = [];

    public static function getService($class)
    {
        $className = ucfirst($class).'Service';
        if(!isset(self::$_services[$className]))
        {
            return self::$_services[$className] = new $className();
        }
        else
        {
            return $_services[$className];
        }
    }
}
