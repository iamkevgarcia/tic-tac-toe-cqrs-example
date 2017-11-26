<?php

declare(strict_types=1);

namespace Kev\Infraestructure\Bus\Event;

use Kev\Shared\Domain\Bus\Event\DomainEvent;
use Kev\Shared\Domain\Bus\Event\DomainEventPublisher;

final class SyncDomainEventPublisher implements DomainEventPublisher
{
    public function subscribe(string $eventClass, callable $subscriber): void
    {

    }

    public function record(DomainEvent ...$domainEvents): void
    {

    }

    public function publishRecorded(): void
    {

    }

    public function publish(DomainEvent ...$domainEvents): void
    {

    }
}
