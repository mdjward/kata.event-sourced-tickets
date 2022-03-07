<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\Infrastructure\EventStore;

final class IncreaseConcertCapacityHandler
{
    public function __construct(private readonly EventStore $eventStore)
    {
    }

    public function __invoke(IncreaseConcertCapacity $command): void
    {
        $streamId = $command->concertId;

        $salesForConcert = SalesForConcert::buildFromHistory($this->eventStore->findEventsByStreamId($streamId));
        $salesForConcert->increaseCapacity($command->additionalCapacity);

        $this->eventStore->appendEventsToStream($streamId, $salesForConcert->popRecordedChanges());
    }
}