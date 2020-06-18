<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateCarParkRequest
 *
 * @property string $name
 *
 * @package App\Http\Requests
 */
class CreateCarParkRequest
    extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:64',
        ];
    }
}