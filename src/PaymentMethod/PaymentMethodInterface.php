<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

namespace ActiveCollab\Payments\PaymentMethod;

/**
 * @package ActiveCollab\Payments\PaymentMethod
 */
interface PaymentMethodInterface
{
    /**
     * @return mixed
     */
    public function getReference();

    /**
     * @return mixed
     */
    public function getOurReference();
}
