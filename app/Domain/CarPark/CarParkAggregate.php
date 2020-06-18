<?php

namespace App\Domain\CarPark;

use App\Domain\CarPark\Events\CarEntered;
use App\Domain\CarPark\Events\CarLeft;
use App\Domain\CarPark\Events\CarParkCreated;
use App\Domain\CarPark\Events\ParkingFeePaid;
use App\Domain\CarPark\Projectors\CarParkProjector;
use App\Domain\CarPark\Projectors\CarReportProjector;
use InvalidArgumentException;
use Spatie\EventSourcing\AggregateRoot;

class CarParkAggregate
    extends AggregateRoot
{
    protected $projectors = [
        CarParkProjector::class,
        CarReportProjector::class,
    ];

    //region --- Commands ---

    public function create(string $name): self
    {
        return $this->recordThat(new CarParkCreated($name));
    }

    public function carEnter(string $licensePlate): self
    {
        if (array_key_exists($licensePlate, $this->_cars))
        {
            throw new InvalidArgumentException("Car with license plate {$licensePlate} is already in car park.");
        }

        return $this->recordThat(new CarEntered($licensePlate));
    }

    public function payParkingFee(string $licensePlate, float $amount): self
    {
        if (!array_key_exists($licensePlate, $this->_cars))
        {
            throw new InvalidArgumentException("Car with license plate {$licensePlate} is not in car park.");
        }
        if ($this->_cars[$licensePlate] === true)
        {
            throw new InvalidArgumentException("Car with license plate {$licensePlate} already paid parking fee.");
        }

        return $this->recordThat(new ParkingFeePaid($licensePlate, $amount));
    }

    public function carLeave(string $licensePlate): self
    {
        if (!array_key_exists($licensePlate, $this->_cars))
        {
            throw new InvalidArgumentException("Car with license plate {$licensePlate} is not in car park.");
        }
        if ($this->_cars[$licensePlate] !== true)
        {
            throw new InvalidArgumentException("Car {$licensePlate} can not leave without paying.");
        }

        return $this->recordThat(new CarLeft($licensePlate));
    }

    //endregion

    //region --- Getters ---

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    //endregion

    //region --- Handlers ---

    public function applyCarParkCreated(CarParkCreated $event)
    {
        $this->_name = $event->name;
    }

    public function applyCarEntered(CarEntered $event)
    {
        $this->_cars[$event->licensePlate] = false;
    }

    public function applyParkingFeePaid(ParkingFeePaid $event)
    {
        $this->_cars[$event->licensePlate] = true;
    }

    public function applyCarLeft(CarLeft $event)
    {
        unset($this->_cars[$event->licensePlate]);
    }

    //endregion

    //region --- Private members ---

    private $_name;
    private $_cars = [];

    //endregion
}
