<?php

namespace ActiveCollab\Payments\Traits;

/**
 * @package ActiveCollab\Payments\Traits
 */
trait OurIdentifier
{
    /**
     * @var string
     */
    private $our_identifier = '';

    /**
     * Return our internal order indetifier (if present)
     *
     * @return string
     */
    public function getOurIdentifier()
    {
        return $this->our_identifier;
    }

    /**
     * Set our identifier
     *
     * @param  string $value
     * @return $this
     */
    public function &setOurIdentifier($value)
    {
        $this->our_identifier = trim($value);

        return $this;
    }
}