<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'active' => 'required|boolean',
            'clt' => 'required|boolean',
            'pj' => 'required|boolean',
            'freelancer' => 'required|boolean',
        ];
    }
}