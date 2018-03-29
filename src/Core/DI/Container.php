<?php

namespace src\Core\DI;

class Container
{
    private static $components = [];

    private static function get($identifier)
    {
        if (!self::$components[$identifier]) {
            $errorMessage = <<<TXT
identifier: {$identifier} does not exist
TXT;

            throw new \Exception($errorMessage);
        }
        
        $class = null;
        if (is_object(self::$components[$identifier])) {
            $class = self::$components[$identifier];
        } else {
            $component = self::$components[$identifier];

            if (isset($component['class']) && empty($component['arguments'])) {
                $className = $component['class'];
                $class = new $className();
            }
            if (isset($component['class']) && !empty($component['arguments'])) {
                
                $arguments = $component['arguments'];
                
                foreach ($arguments as $index => $value) {
                    if (class_exists($value)) {
                        $value = self::get($value);
                    }
                    $arguments[$index] = $value;
                }
                
                $className = $component['class'];
                $reflection = new \ReflectionClass($className);
                $class = $reflection->newInstanceArgs($arguments);
            }
        }
        
        if (!is_object(self::$components[$identifier])) {
            self::$components[$identifier] = $class;
        }
        
        return self::$components[$identifier];
    }

    /**
     * @param $identifier
     * @return mixed
     * @throws \Exception
     */
    public static function getCreated($identifier)
    {
        return clone self::get($identifier);
    }

    /**
     * @param string $identifier
     * @param array $arguments
     */
    public static function set($identifier, $arguments = [])
    {
        if (!isset(self::$components[$identifier])) {
            self::$components[$identifier] = [
                'class' => $identifier,
                'arguments' => $arguments
            ];
        }
    }
}
