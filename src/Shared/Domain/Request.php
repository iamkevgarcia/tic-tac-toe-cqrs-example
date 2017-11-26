<?php

declare (strict_types = 1);

namespace Kev\Shared\Domain;

use Kev\Types\ValueObject\Uuid;

abstract class Request extends Message
{
    public function requestId(): Uuid
    {
        return $this->messageId();
    }
}
