<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Merchant;

use ActiveCollab\Object\ObjectInterface;
use ActiveCollab\Payments\Common\InternallyIdentifiedObjectInterface;
use ActiveCollab\Payments\Common\ReferencedObjectInterface;

interface MerchantInterface extends InternallyIdentifiedObjectInterface, ObjectInterface, ReferencedObjectInterface
{
}
