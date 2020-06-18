<?php

namespace App\Http\Controllers\Api;

use App\Domain\CarPark\CarParkAggregate;
use App\Http\Requests\CarEnterRequest;
use App\Http\Requests\CreateCarParkRequest;
use App\Http\Requests\PayParkingFeeRequest;
use App\Models\CarPark;
use App\Models\CarReport;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CarParkController
    extends ApiControllerBase
{
    use DispatchesJobs, ValidatesRequests;

    //region --- Car Parks management ---

    public function listCarParks(): Response
    {
        return response(CarPark::all());
    }

    public function getCarPark(string $uuid): Response
    {
        return response(self::requireCarPark($uuid));
    }

    public function createCarPark(CreateCarParkRequest $request): Response
    {
        $uuid = Uuid::uuid4();
        CarParkAggregate::retrieve($uuid)
                        ->create($request->name)
                        ->persist();

        return response(['uuid' => $uuid]);
    }

    //endregion

    //region --- Cars management ---

    public function carEnter(string $uuid, CarEnterRequest $request): Response
    {
        CarParkAggregate::retrieve($uuid)
                        ->carEnter($request->licensePlate)
                        ->persist();

        return response()->noContent();
    }

    public function payParkingFee(string $uuid, string $licensePlate, PayParkingFeeRequest $request): Response
    {
        CarParkAggregate::retrieve($uuid)
                        ->payParkingFee($licensePlate, $request->amount)
                        ->persist();

        return response()->noContent();
    }

    public function carLeave(string $uuid, string $licensePlate): Response
    {
        CarParkAggregate::retrieve($uuid)
                        ->carLeave($licensePlate)
                        ->persist();

        return response()->noContent();
    }

    //endregion

    //region --- Car reports ---

    public function listCarReports(): Response
    {
        return response(CarReport::all());
    }

    //endregion

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
