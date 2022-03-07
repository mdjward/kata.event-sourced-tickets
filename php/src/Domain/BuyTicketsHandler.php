<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\Infrastructure\EventStore;

/**
 * FYI : I'm breaking my own rule about not naming a class according to its function
 */
final class BuyTicketsHandler
{
    private EventStore $eventStore;

    /**
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function handle(BuyTickets $command)
    {
        $streamId = $command->getConcertId();

        $salesForConcert = SalesForConcert::buildFromHistory($this->eventStore->findEventsByStreamId($streamId));
        $salesForConcert->buyTickets($command->getCustomerId(), $command->getQuantity());

        $this->eventStore->appendEventsToStream($streamId, $salesForConcert->getRecordedChanges());
    }
}