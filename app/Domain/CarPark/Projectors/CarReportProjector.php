<?php

namespace App\Domain\CarPark\Projectors;

use App\Domain\CarPark\Events\CarEntered;
use App\Domain\CarPark\Events\ParkingFeePaid;
use App\Models\CarReport;
use Spatie\EventSourcing\Projectors\Projector;
use Spatie\EventSourcing\Projectors\ProjectsEvents;

class CarReportProjector
    implements Projector
{
    use ProjectsEvents;

    protected $handlesEvents = [
        CarEntered::class => 'onCarEntered',
        ParkingFeePaid::class => 'onParkingFeePaid',
    ];

    public function onCarEntered(CarEntered $event, string $aggregateUuid)
    {
        $report = CarReport::licensePlate($event->licensePlate);
        if ($report === null)
        {
            // new license plate
            $report = new CarReport();
            $report->license_plate = $event->licensePlate;
        }

        $report->visit_count++;
        $report->save();
    }

    public function onParkingFeePaid(ParkingFeePaid $event)
    {
        $report = CarReport::licensePlate($event->licensePlate);
        if ($report !== null)
        {
            $report->amount_paid += $event->amount;
            $report->save();
        }
    }
}