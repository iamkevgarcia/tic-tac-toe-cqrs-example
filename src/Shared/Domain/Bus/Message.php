<?php

declare (strict_types = 1);

namespace Kev\Shared\Domain\Bus;

use Kev\Types\ValueObject\Uuid;

abstract class Message
{
    private $messageId;

    public function __construct(Uuid $messageId)
    {
        $this->messageId = $messageId;
    }

    public function messageId(): Uuid
    {
        return $this->messageId;
    }
}
