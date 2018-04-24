<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach;


use src\App\Blackboard\FormNew\SymfonyApproach\Components\Provider\ProviderDataIterator;

class Resolver implements ResolverInterface
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var mixed
     */
    private $matchData;

    /**
     * @var array
     */
    private $toResolve;

    /**
     * @var 
     */
    private $transformer;

    /**
     * Resolver constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param array $options
     */
    public function setDefault($options)
    {
        if (isset($options['data_class'])) {
            if ($options['data_class'] === get_class($this->data)) {
                $this->toResolve = $this->data;
            } else {
                echo "wrong class";
            }

        }
        if (isset($options['iterable'])) {
            $iterable = $options['iterable'];
            $provider = null; // typical foreach
            if (isset($iterable['provider'])) {
                $provider = $iterable['provider'];
                $iteratorClass = $iterable['data_class'];
                $iteratorIdentifier = $iterable['identifier'];
                $postRelevant = [];
                if (isset($iterable['post_relevant'])) {
                    $postRelevant = $iterable['post_relevant'];
                }
                $this->toResolve = new ProviderDataIterator(
                    $this->data,
                    $provider,
                    $iteratorClass,
                    $iteratorIdentifier,
                    $postRelevant
                );
            }
            if (isset($iterable['data_match'])) {
                $matchDataArray = $iterable['data_match'];
                if (isset($matchDataArray['provider'])) {
                    $provider = $matchDataArray['provider'];
                    $iteratorClass = $matchDataArray['data_class'];
                    $iteratorIdentifier = $matchDataArray['identifier'];
                    $postRelevant = [];
                    if (isset($iterable['post_relevant'])) {
                        $postRelevant = $iterable['post_relevant'];
                    }
                    $addAttributes = $matchDataArray['add_attributes'];
                    $data = $matchDataArray['data'];
                    $this->matchData = new ProviderDataIterator(
                        $data,
                        $provider,
                        $iteratorClass,
                        $iteratorIdentifier,
                        $postRelevant,
                        $addAttributes
                    );
                }
            }
        }
        if (isset($options['transformer'])) {
            $transformerOptions = $options['transformer'];
            if (isset($transformerOptions['post'])) { /** @todo structure for more transformers */                
                $this->transformer = $transformerOptions['post'];
            }
        }
    }

    /**
     * @return array
     */
    public function getToResolve()
    {
        return $this->toResolve;
    }

    public function forceToResolve($data)
    {
        $this->toResolve = $data;
    }

    /**
     * @return mixed
     */
    public function getMatchData()
    {
        return $this->matchData;
    }

    public function forceMatchData($matchData)
    {
        $this->matchData = $matchData;
    }

    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}