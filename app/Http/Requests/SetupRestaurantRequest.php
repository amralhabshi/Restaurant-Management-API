<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetupRestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
            // Restaurant

            'restaurant_name'=>['required','string','max:255'],

            'restaurant_phone'=>['nullable','string'],

            'restaurant_email'=>['nullable','email'],

            'description'=>['nullable','string'],


            // Branch

            'branch_name'=>['required','string'],

            'city'=>['required','string'],

            'address'=>['required','string'],

            'opening_time'=>['required'],

            'closing_time'=>[ 'required'],
        ];
    }
}
