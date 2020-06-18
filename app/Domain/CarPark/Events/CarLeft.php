<?php

namespace App\Domain\CarPark\Events;

use Spatie\EventSourcing\ShouldBeStored;

class CarLeft
    implements ShouldBeStored
{
    /** @var string */
    public $licensePlate;

    public function __construct(string $licensePlate)
    {
        $this->licensePlate = $licensePlate;
    }
}