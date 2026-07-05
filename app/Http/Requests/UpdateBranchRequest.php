<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
        'name'=>['sometimes','string','max:255'],

        'phone'=>['nullable','string','max:20'],

        'city'=>['sometimes','string','max:100'],

        'address'=>['nullable','string'],

        'opening_time'=>['sometimes'],

        'closing_time'=>['sometimes'],
        ];
    }
}
