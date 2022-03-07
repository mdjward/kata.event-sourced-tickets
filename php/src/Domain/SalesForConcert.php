<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\DomainEvent;

final class SalesForConcert
{
    /**
     * @var DomainEvent[]
     */
    private array $recordedEvents = [];

    private string $id;

    private int $capacity;

    /**
     * @param DomainEvent[] $events
     */
    public static function buildFromHistory(array $events): self
    {
        $instance = new self();

        foreach ($events as $event) {
            $instance->apply($event);
        }

        return $instance;
    }

    private function apply(DomainEvent $event): void
    {
        if ($event instanceof ConcertPlanned) {
            $this->id = $event->getConcertId();
            $this->capacity = $event->getCapacity();
        } else if ($event instanceof TicketsSold) {
            $this->capacity -= $event->getQuantity();
        }
    }

    public function buyTickets(string $customerId, int $quantity): void
    {
        if ($quantity > $this->capacity) {
            throw new NoTicketsAvailableAnymore();
        }

        $this->recordedEvents[] = new TicketsSold($this->id, $customerId, $quantity);
    }

    /**
     * @return DomainEvent[]
     */
    public function getRecordedChanges(): array
    {
        return $this->recordedEvents;
    }
}