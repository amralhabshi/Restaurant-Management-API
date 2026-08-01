<?php

namespace App\Http\Requests;

use App\Enums\TableStatus;
use App\Enums\TableType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTableRequest extends FormRequest
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

            'table_number' => [
                'sometimes',
                'string',
                'max:50',
            ],

            'type' => [
                'sometimes',
                new Enum(TableType::class),
            ],

            'capacity' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'status' => [
                'sometimes',
                new Enum(TableStatus::class),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required.',
        ];
    }

    public function attributes(): array
    {
        return [
            'table_number' => 'table number',
        ];
    }
}
