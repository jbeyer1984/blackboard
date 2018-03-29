<?php

namespace src\Core\DI;

abstract class ServiceComponent
{
    private $components = [];
    
    private $logEntries = [];

    /**
     * configure service
     * @return void
     */
    abstract public function register();

    /**
     * @param $identifier
     * @param string $indent
     * @return mixed
     */
    private function get($identifier, $indent = '')
    {
        if (!isset($this->components[$identifier])) {
            $errorMessage = <<<TXT
identifier: {$identifier} does not exist
TXT;

            throw new \Exception($errorMessage);
        }

        $class = null;
        if (is_object($this->components[$identifier])) {
            $class = $this->components[$identifier];
        } else {
            $component = $this->components[$identifier];
            
            if (isset($component['class']) && empty($component['arguments'])) {
                $className = $component['class'];
                $class = new $className();
            }
            if (isset($component['class']) && !empty($component['arguments'])) {
                $className = $component['class'];
                $arguments = $component['arguments'];

                $this->fillTraceClass($className, $indent);
                foreach ($arguments as $index => $value) {
                    if (!is_object($value) && class_exists($value)) {
                        $this->fillTraceArguments($value, $indent);
                        $value = $this->get($value, $indent . '  ');
                    } else {
                        if (is_object($value)) {
                            $this->fillTraceArguments(get_class($value), $indent);
                        } else {
                            $this->fillTraceArguments($value, $indent);
                        }
                    }                    
                    $arguments[$index] = $value;
                }

                $reflection = new \ReflectionClass($className);
                $class = $reflection->newInstanceArgs($arguments);
            }
        }

        if (!is_object($this->components[$identifier])) {
            $this->components[$identifier] = $class;
        }

        return $this->components[$identifier];
    }

    /**
     * @param $identifier
     * @return mixed
     */
    public function getCreated($identifier)
    {
        $obj = clone $this->get($identifier);
        $trace = $this->getTraceString();
        if (defined('TRACE_ON') && !empty($trace)) {
            $dump = print_r($trace, true);
            error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $trace ***' . PHP_EOL . " = " . $dump . PHP_EOL);

        }
        
        return $obj;
    }

    /**
     * @param $identifier
     * @return mixed
     */
    public function getSingle($identifier)
    {
        $obj = $this->get($identifier);

        $trace = $this->getTraceString();
        if (defined('TRACE_ON') && !empty($trace)) {
            $dump = print_r($trace, true);
            error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $trace ***' . PHP_EOL . " = " . $dump . PHP_EOL);

        }
            
        return $obj;
    }

    /**
     * @param string $identifier
     * @param array $arguments
     * @return ServiceComponent
     */
    public function set($identifier, $arguments = [])
    {
        if (!isset($this->components[$identifier])) {
            $this->components[$identifier] = [
                'class' => $identifier,
                'arguments' => $arguments
            ];
        }
        
        return $this;
    }

    /**
     * @param $identifier
     * @param $obj
     */
    public function inject($identifier, $obj)
    {
        $this->injectError($identifier);

        $this->components[$identifier] = $obj;
    }

    /**
     * @param $identifier
     * @throws \Exception
     */
    private function injectError($identifier)
    {
        if (isset($this->components[$identifier])) {
            $errorMessage = <<<TXT
you want to use src\inject and overwrite existing entry: $identifier
TXT;
            throw new \Exception($errorMessage);
        }
    }

    private function fillTraceClass($identifier, $indent)
    {
        $entries = array_map(function ($row) {
            return str_replace(' ', '', $row);
        }, $this->logEntries);
//        $dump = print_r($entries, true);
//        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $entries ***' . PHP_EOL . " = " . $dump . PHP_EOL);
        
        if (!in_array($identifier, $entries)) {
            $this->logEntries[] = $indent . $identifier;
        }
    }

    private function fillTraceArguments($identifier, $indent)
    {
        $this->logEntries[] = $indent . '  ' . $identifier;
    }

    /**
     * @return string
     */
    public function getTraceString()
    {
        $message = '';
        if (0 < count($this->logEntries)) {
            $message = PHP_EOL;
            foreach ($this->logEntries as $str) {
                $message .= $str . PHP_EOL;
            }    
        }

        return $message;
    }
}
