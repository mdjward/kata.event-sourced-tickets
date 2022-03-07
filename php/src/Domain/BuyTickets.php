<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\Command;

final class BuyTickets implements Command
{
    public function __construct(
        public readonly string $concertId,
        public readonly string $customerId,
        public readonly string $quantity
    ) {
    }
}
