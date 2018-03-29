<?php

namespace src\Core\DI;

class Service
{
    /**
     * @var array
     */
    private static $components = [];

    /**
     * @param string $identifier
     * @return ServiceComponent
     */
    public static function get($identifier)
    {
        $namespace = self::getNamespace($identifier);
        
        if (!self::has($namespace)) {
            $className = $identifier;
            /** @var ServiceComponent $service */
            $service = new $className();
            $service->register();
            self::$components[$namespace] = $service;
        }
        
        /** @var ServiceComponent $service */
        $service = self::$components[$namespace];
        
        return $service;
    }

    /**
     * @param $identifier
     * @return string
     */
    private static function getNamespace($identifier)
    {
//        $namespace = get_class($identifier);
        $exploded  = explode('\\', $identifier);
        array_pop($exploded);
        $namespace = implode('\\', $exploded);

        return $namespace;
    }

    /**
     * @param string $identifier
     * @param mixed $obj
     */
    public static function overwrite($identifier, $obj)
    {
        $namespace = self::getNamespace($identifier);
        self::$components[$namespace] = $obj;
    }

    /**
     * @param string $namespace
     * @return bool
     */
    private static function has($namespace)
    {
        $componentExists = false;
        
        if (isset(self::$components[$namespace])) {
            $componentExists = true;
        }
        
        return $componentExists;
    }
}
