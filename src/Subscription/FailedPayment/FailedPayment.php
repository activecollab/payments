<?php

namespace ActiveCollab\Payments\Subscription\FailedPayment;

use ActiveCollab\Payments\Traits\Gateway;
use ActiveCollab\Payments\Traits\Timestamp;

/**
 * @package ActiveCollab\Payments\Subscription\FailedPayment
 */
class FailedPayment implements FailedPaymentInterface
{
    use Gateway, Timestamp;
}
