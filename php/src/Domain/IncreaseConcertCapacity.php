<?php

namespace Aardling\Concerts\Domain;

use Aardling\Concerts\Command;

final class IncreaseConcertCapacity implements Command
{
    public function __construct(
        public readonly string $concertId,
        public readonly int $additionalCapacity
    ) {
    }
}