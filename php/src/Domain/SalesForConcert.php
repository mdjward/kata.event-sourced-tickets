<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\DomainEvent;

final class SalesForConcert
{
    /**
     * @param DomainEvent[] $events
     */
    public static function buildFromHistory(array $events): self
    {
        //@todo do something here
    }

    public function buyTickets(string $customerId, int $quantity): void
    {
        //@todo do something here
    }

    /**
     * @return DomainEvent[]
     */
    public function getRecordedChanges(): array
    {
        //@todo do something here
    }
}