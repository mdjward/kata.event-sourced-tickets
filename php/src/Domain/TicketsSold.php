<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\DomainEvent;

final class TicketsSold implements DomainEvent
{
    private string $concertId;
    private string $customerId;
    private int $quantity;

    /**
     * @param string $concertId
     * @param string $customerId
     * @param int $quantity
     */
    public function __construct(string $concertId, string $customerId, int $quantity)
    {
        $this->concertId = $concertId;
        $this->customerId = $customerId;
        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getConcertId(): string
    {
        return $this->concertId;
    }

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getStreamId(): string
    {
        return $this->concertId;
    }
}