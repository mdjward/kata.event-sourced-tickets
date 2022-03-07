<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\DomainEvent;

final class TicketsSold implements DomainEvent
{
    public function __construct(
        public readonly string $concertId,
        public readonly string $customerId,
        public readonly int $quantity
    ) {
    }

   public function streamId(): string
    {
        return $this->concertId;
    }
}