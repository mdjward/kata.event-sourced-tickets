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

    private function record(DomainEvent $event): void
    {
        $this->recordedEvents[] = $event;
        $this->apply($event);
    }

    private function apply(DomainEvent $event): void
    {
        if ($event instanceof ConcertPlanned) {
            $this->id = $event->concertId;
            $this->capacity = $event->capacity;
        } else if ($event instanceof TicketsSold) {
            $this->capacity -= $event->quantity;
        } else if ($event instanceof ConcertCapacityIncreased) {
            $this->capacity += $event->additionalCapacity;
        }
    }

    public function buyTickets(string $customerId, int $quantity): void
    {
        if ($quantity > $this->capacity) {
            throw new NoTicketsAvailableAnymore();
        }

        $this->record(new TicketsSold($this->id, $customerId, $quantity));
    }

    public function increaseCapacity(int $additionalCapacity): void
    {
        $this->record(new ConcertCapacityIncreased($this->id, $additionalCapacity));
    }

    /**
     * @return DomainEvent[]
     */
    public function popRecordedChanges(): array
    {
        $recordedEvents = $this->recordedEvents;
        $this->recordedEvents = [];

        return $recordedEvents;
    }
}