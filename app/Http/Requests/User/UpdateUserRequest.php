<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class UpdateUserRequest extends FormRequest
{
    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $parameter = $this->route->parameter('id');
        return [
            'name' => ['string', 'min:3', 'max:255'],
            'email' => ['string', 'email', 'max:255', "unique:users,email,{$parameter},id"],
            'password' => ['string', 'min:8', 'confirmed'],
        ];
    }
}
