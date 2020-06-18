<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CarEnterRequest
 *
 * @property string $licensePlate
 *
 * @package App\Http\Requests
 */
class CarEnterRequest
    extends FormRequest
{
    public function rules()
    {
        return [
            'licensePlate' => 'required|string|max:12',
        ];
    }
}