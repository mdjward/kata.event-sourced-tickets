<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\DomainEvent;

final class ConcertCapacityIncreased implements DomainEvent
{
    public function __construct(
        public readonly string $customerId,
        public readonly int $additionalCapacity
    ) {
    }

    public function streamId(): string
    {
        return $this->customerId;
    }
}