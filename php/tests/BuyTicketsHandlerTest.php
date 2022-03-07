<?php

namespace Aardling\Concerts;

use Aardling\Concerts\Domain\ConcertPlanned;
use Aardling\Concerts\Domain\BuyTickets;
use Aardling\Concerts\Domain\BuyTicketsHandler;
use Aardling\Concerts\Domain\NoTicketsAvailableAnymore;
use Aardling\Concerts\Domain\TicketsSold;
use Aardling\Concerts\Infrastructure\DummyRecordingEventStore;
use PHPUnit\Framework\TestCase;

/*
 * @todo : these tests are intentionally left superficial, naive and incomplete
 * it just serves as a starting point for adding more tests if that would help you
 */
final class BuyTicketsHandlerTest extends TestCase
{
    private $handler;
    private $eventstore;
    private Command $command;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventstore = new DummyRecordingEventStore();
        $this->handler = new BuyTicketsHandler($this->eventstore);
    }

    /**
     * @test
     */
    public function it_should_allow_to_reserve_the_only_ticket_available_if_it_wasnt_sold_yet()
    {
        $concertId = 'concert-123';
        $customerId = 'customer-1';

        $this->given(new ConcertPlanned($concertId, 1));
        $this->when(new BuyTickets($concertId, $customerId, 1));
        $this->then([new TicketsSold($concertId, $customerId, 1)]);
    }

    /**
     * @test
     */
    public function it_should_disallow_ticket_sales_when_the_concert_doesnt_have_initial_capacity()
    {
        $concertId = 'concert-123';
        $customerId = 'customer-1';

        $this->given(new ConcertPlanned($concertId, 0));
        $this->when(new BuyTickets($concertId, $customerId, 1));
        $this->exception(NoTicketsAvailableAnymore::class);
    }

    /**
     * @test
     */
    public function it_should_disallow_ticket_sales_for_more_than_the_capacity()
    {
        $concertId = 'concert-123';
        $customerId = 'customer-1';

        $this->given(new ConcertPlanned($concertId, 10));
        $this->when(new BuyTickets($concertId, $customerId, 11));
        $this->exception(NoTicketsAvailableAnymore::class);
    }

    /**
     * @test
     */
    public function it_should_take_already_sold_tickets_into_account()
    {
        $concertId = 'concert-123';
        $customerId = 'customer-1';
        $otherCustomerId = 'customer-2';

        $this->given(new ConcertPlanned($concertId, 10));
        $this->given(new TicketsSold($concertId, $otherCustomerId, 10));
        $this->when(new BuyTickets($concertId, $customerId, 1));
        $this->exception(NoTicketsAvailableAnymore::class);
    }





    /*
     * Test framework code that could be extracted
     */

    private function given(DomainEvent $event): void
    {
        $this->eventstore->appendExistingEventsToStream($event->getStreamId(), [$event]);
    }

    private function when(Command $command): void
    {
        $this->command = $command;
    }

    private function then(array $events): void
    {
        $this->handler->handle($this->command);
        $this->assertEquals($events, $this->eventstore->getNewEvents());
    }

    private function exception(string $expectedException)
    {
        $this->expectException($expectedException);
        $this->handler->handle($this->command);
    }
}
