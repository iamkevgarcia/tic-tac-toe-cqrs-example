<?php

declare (strict_types = 1);

namespace Kev\Shared\Domain\Bus\Command;

use Kev\Shared\Domain\Bus\Request;
use Kev\Types\ValueObject\Uuid;

abstract class Command extends Request
{
    public function commandId(): Uuid
    {
        return $this->requestId();
    }
}
