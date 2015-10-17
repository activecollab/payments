<?php

namespace ActiveCollab\Payments\Traits;

/**
 * @package ActiveCollab\Payments\Traits
 */
trait Reference
{
    /**
     * @var string
     */
    private $reference;

    /**
     * Return parent reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
}