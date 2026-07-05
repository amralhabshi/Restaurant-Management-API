<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        return 
        [
        'first_name'=>['sometimes','string','max:100'],

        'last_name'=>['sometimes','string'],

        'phone'=>['sometimes','string'],

        'email'=>['sometimes','email'],

        'salary'=>['nullable','numeric'],

        'hire_date'=>['sometimes','date'],
        
        'status'=>['sometimes','in:active,inactive']
        ];
    }
}
