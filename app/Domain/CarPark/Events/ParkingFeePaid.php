<?php

namespace App\Domain\CarPark\Events;

use Spatie\EventSourcing\ShouldBeStored;

class ParkingFeePaid
    implements ShouldBeStored
{
    /** @var string */
    public $licensePlate;

    /** @var float */
    public $amount;

    public function __construct(string $licensePlate, float $amount)
    {
        $this->licensePlate = $licensePlate;
        $this->amount = $amount;
    }
}