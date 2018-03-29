<?php


namespace src\Router\Request;


class GetPostAbstract
{
    /**
     * @var array
     */
    private $data;

    public function add($index, $value)
    {
        $this->data[$index] = $value;
    }

    public function get($index, $default = '')
    {
        if (empty($default) && !isset($this->data[$index])) {
            $message = <<<TXT
the parameter: {$index} in post does not exist 
TXT;

            throw new \Exception($message);
        }

        if (!empty($default) && !isset($this->data[$index])) {
            return $default;
        }

        return $this->data[$index];
    }
}