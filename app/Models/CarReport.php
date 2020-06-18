<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CarReport
 *
 * @property string $license_plate
 * @property int    $visit_count
 * @property float  $amount_paid
 *
 * @package App\Models
 */
class CarReport
    extends Model
{
    protected $primaryKey = 'license_plate';
    protected $keyType = 'string';

    public static function licensePlate(string $licensePlate): ?CarReport
    {
        return static::where('license_plate', $licensePlate)->first();
    }
}