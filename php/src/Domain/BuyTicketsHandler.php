<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\Infrastructure\EventStore;

/**
 * FYI : I'm breaking my own rule about not naming a class according to its function
 */
final class BuyTicketsHandler
{
    public function __construct(private readonly EventStore $eventStore)
    {
    }

    public function __invoke(BuyTickets $command): void
    {
        $streamId = $command->concertId;

        $salesForConcert = SalesForConcert::buildFromHistory($this->eventStore->findEventsByStreamId($streamId));
        $salesForConcert->buyTickets($command->customerId, $command->quantity);

        $this->eventStore->appendEventsToStream($streamId, $salesForConcert->getRecordedChanges());
    }
}