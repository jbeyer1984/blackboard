<?php


namespace src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\Dispatcher;


use src\Core\Form\Components\Provider\ProviderDataIterator;
use src\Core\Form\Dispatcher\DispatchInterface;
use src\Core\Form\Resolver;

class IteratorDataDispatcher implements DispatchInterface
{
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @var
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
        $this->dataArray        = [];
        $this->dataToMatchArray = [];
    }

    public function dispatch()
    {
        $data = $this->resolver->getToResolve();
        $dataToMatch = $this->resolver->getMatchData();
        $this->iteratorDispatcher($data, $dataToMatch, $this->nameChain);
    }

    /**
     * @param $data
     * @param $dataToMatch
     * @param $nameChain
     * @return array
     */
    private function iteratorDispatcher($data, $dataToMatch, $nameChain)
    {
        if (!empty($dataToMatch)) {
            $this->dataToMatchArray = $this->getDeterminedIteratorDataArray($dataToMatch, $nameChain);
        }
        $this->dataArray = $this->getDeterminedIteratorDataArray($data, $nameChain);
    }

    /**
     * @param ProviderDataIterator $data
     * @param string $nameChain
     * @return array
     */
    private function getDeterminedIteratorDataArray(ProviderDataIterator $data, $nameChain)
    {
        $providerClass = $data->getProvider();
        $provider      = new $providerClass($data->getData());
        $dataArray = [];
        foreach ($provider as $iteratorClass) {
            if ($data->getIteratorClass() == get_class($iteratorClass)) {
                $getMethod               = 'get' . ucfirst($data->getIdentifier());
                $iteratorClassIdentifier = $iteratorClass->$getMethod();
                $iteratorNameChain       = <<<TXT
{$nameChain}[{$iteratorClassIdentifier}]
TXT;
                $dataArray[$iteratorNameChain] = $iteratorClass;
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
     * @return mixed
     */
    public function getNameChain()
    {
        return $this->nameChain;
    }
}