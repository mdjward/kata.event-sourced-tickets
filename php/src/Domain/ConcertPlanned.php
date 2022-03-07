<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\DomainEvent;

final class ConcertPlanned implements DomainEvent
{
    public function __construct(
        public readonly string $concertId,
        public readonly int $capacity
    ) {
    }

    public function streamId(): string
    {
        return $this->concertId;
    }
}