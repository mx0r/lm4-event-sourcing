<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PayParkingFeeRequest
 *
 * @property int $amount
 *
 * @package App\Http\Requests
 */
class PayParkingFeeRequest
    extends FormRequest
{
    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:0.1',
        ];
    }
}