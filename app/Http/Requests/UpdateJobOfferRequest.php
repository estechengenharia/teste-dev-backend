<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'active' => 'sometimes|boolean',
            'CLT' => 'sometimes|boolean',
            'PJ' => 'sometimes|boolean',
            'Freelancer' => 'sometimes|boolean',
        ];
    }
}