<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\Command;

final class BuyTickets implements Command
{
    private string $concertId;
    private string $customerId;
    private string $quantity;

    /**
     * @param string $concertId
     * @param string $customerId
     * @param string $quantity
     */
    public function __construct(string $concertId, string $customerId, string $quantity)
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
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }
}
