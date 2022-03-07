<?php

namespace Aardling\Concerts\Infrastructure;

/**
 * this is a very naive implementation
 * but it is sufficient as an example and for some (isolated, naive) unit testing of command handlers and aggregates
 */
final class DummyRecordingEventStore implements EventStore
{
    private array $pastEvents = [];
    private array $newEvents = [];

    public function appendExistingEventsToStream(string $streamId, array $domainEvents): void
    {
        //@todo store by stream
        $this->pastEvents = array_merge($this->pastEvents, $domainEvents);
    }

    public function getNewEvents()
    {
        return $this->newEvents;
    }

    public function appendEventsToStream(string $streamId, array $domainEvents): void
    {
        //@todo store by stream
        $this->newEvents = array_merge($this->newEvents, $domainEvents);
    }

    public function findEventsByStreamId(string $streamId): array
    {
        //@todo fecth by stream
        return array_merge($this->pastEvents, $this->newEvents);
    }

}