<?php

namespace App\Domain\CarPark\Projectors;

use App\Domain\CarPark\Events\CarEntered;
use App\Domain\CarPark\Events\CarLeft;
use App\Domain\CarPark\Events\CarParkCreated;
use App\Models\CarPark;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CarParkProjector
    implements Projector
{
    use ProjectsEvents;

    protected $handlesEvents = [
        CarParkCreated::class => 'onCarParkCreated',
        CarEntered::class => 'onCarEntered',
        CarLeft::class => 'onCarLeft',
    ];

    public function onCarParkCreated(CarParkCreated $event, string $aggregateUuid)
    {
        $carPark = new CarPark(['uuid' => $aggregateUuid, 'name' => $event->name]);
        $carPark->save();
    }

    public function onCarEntered(CarEntered $event, string $aggregateUuid)
    {
        $carPark = self::requireCarPark($aggregateUuid);
        $carPark->car_counter++;
        $carPark->save();
    }

    public function onCarLeft(CarLeft $event, string $aggregateUuid)
    {
        $carPark = self::requireCarPark($aggregateUuid);
        $carPark->car_counter--;
        $carPark->save();
    }

    //region --- Private ---

    private static function requireCarPark(string $uuid): CarPark
    {
        $carPark = CarPark::uuid($uuid);
        if ($carPark === null)
        {
            throw new NotFoundHttpException('Car Park not found.');
        }

        return $carPark;
    }

    //endregion
}