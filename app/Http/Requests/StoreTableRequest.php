<?php

namespace App\Http\Requests;

use App\Enums\TableStatus;
use App\Enums\TableType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
                'required',
                'string',
                'max:50',
            ],

            'type' => [
                'required',
                new Enum(TableType::class),
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
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
