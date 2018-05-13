<?php


namespace src\Router\Request;


class GetPostBase
{
    /**
     * @var array
     */
    private $data;

    /**
     * GetPostAbstract constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

//    public function add($index, $value)
//    {
//        $this->data[$index] = $value;
//    }

    public function get($index, $default = '')
    {
        if ('' === $default && !isset($this->data[$index])) {
            $this->getIdentifierExceptionNotFound($index);
        }

        if ('' !== $default && !isset($this->data[$index])) {
            return $default;
        }

        return $this->data[$index];
    }

    /**
     * @param $index
     * @throws \Exception
     */
    private function getIdentifierExceptionNotFound($index)
    {
        $message = <<<TXT
the parameter: {$index} in post does not exist 
TXT;

        throw new \Exception($message);
    }

    /**
     * @return array
     */
    public function getAllParams()
    {
        return $this->data;
    }
}