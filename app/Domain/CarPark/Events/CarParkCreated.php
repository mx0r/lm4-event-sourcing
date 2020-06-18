<?php

namespace App\Domain\CarPark\Events;

use Spatie\EventSourcing\ShouldBeStored;

class CarParkCreated
    implements ShouldBeStored
{
    /** @var string */
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}