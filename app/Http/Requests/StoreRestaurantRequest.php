<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreRestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * هل مسموح بتنفيذ العملية
         */
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
        'name'=>['required','string','max:255'],

        'phone'=>['required','string','max:20'],

        'email'=>['required','email',Rule::unique('restaurants')],

        'description'=>['nullable','string']
        ];
    }

    
    public function messages(): array
    {
        return [
            'email.unique'=>'This restaurant email already exists'
        ];
    }

    
    public function attributes(): array
    {
        return [
            'name'=>'restaurant name',
            'phone'=>'restaurant number',
        ];
    }
}
