<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CarPark
 *
 * @property int    $id
 * @property string $uuid
 * @property string $name
 * @property int    $car_counter;
 *
 * @package App\Models
 */
class CarPark
    extends Model
{
    protected $fillable = [
        'uuid', 'name',
    ];

    public static function uuid(string $uuid): ?CarPark
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return static::where('uuid', $uuid)->first();
    }
}
