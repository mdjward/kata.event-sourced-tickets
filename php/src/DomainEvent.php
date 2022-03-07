<?php

namespace Aardling\Concerts;

interface DomainEvent
{
    public function streamId(): string;
}
