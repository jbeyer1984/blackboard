<?php


namespace src\App\Overview;


use src\Utilities\Service\BaseUtilities;

class Overview
{
    /**
     * @var BaseUtilities
     */
    private $base;

    /**
     * Overview constructor.
     * @param BaseUtilities $base
     */
    public function __construct(BaseUtilities $base)
    {
        $this->base = $base;
    }

    public function show()
    {
        $this->base->getTemplate()->getView('a_overview/overview.php', []);
    }

}