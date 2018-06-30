<?php


namespace src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\Dispatcher;


use src\Core\Form\Dispatcher\DispatchInterface;
use src\Core\Form\Resolver;

class DataDispatcher implements DispatchInterface
{
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @var string
     */
    private $nameChain;

    /**
     * @var array
     */
    private $dataArray;

    /**
     * @var array
     */
    private $dataToMatchArray;

    /**
     * IteratorDispatcher constructor.
     * @param Resolver $resolver
     * @param string $nameChain
     */
    public function __construct(Resolver $resolver, $nameChain)
    {
        $this->resolver = $resolver;
        $this->nameChain = $nameChain;

        $this->init();
    }

    protected function init()
    {
        $this->dataArray = [];
        $this->dataToMatchArray = [];
    }

    public function dispatch()
    {
        $data = $this->resolver->getToResolve();
        $dataToMatch = $this->resolver->getMatchData();
        $this->dataDispatcher($data, $dataToMatch, $this->nameChain);
    }

    /**
     * @param $data
     * @param $dataToMatch
     * @param $nameChain
     */
    private function dataDispatcher($data, $dataToMatch, $nameChain)
    {
        if (!empty($dataToMatch)) {
            $this->dataToMatchArray = $this->getDeterminedDataArray($dataToMatch, $nameChain);
        }
        $this->dataArray = $this->getDeterminedDataArray($data, $nameChain);
    }

    /**
     * @param array $dataToIterate
     * @param $nameChain
     * @return array
     */
    private function getDeterminedDataArray($dataToIterate, $nameChain)
    {
        $dataArray = [];
        $iteratorNameChain = <<<TXT
{$nameChain}
TXT;
        if (!is_array($dataToIterate)) {
            $dataArray[$iteratorNameChain] = $dataToIterate;
        } else {
            foreach ($dataToIterate as $index => $iteratorClass) {

                $dataArray[$iteratorNameChain][$index] = $iteratorClass;
            }
        }

        return $dataArray;
    }

    /**
     * @return array
     */
    public function getDataArray()
    {
        return $this->dataArray;
    }

    /**
     * @return array
     */
    public function getDataToMatchArray()
    {
        return $this->dataToMatchArray;
    }

    /**
     * @return string
     */
    public function getNameChain()
    {
        return $this->nameChain;
    }


}