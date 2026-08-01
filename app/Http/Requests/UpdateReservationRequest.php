<?php

namespace App\Http\Requests;

use App\Enums\ReservationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateReservationRequest extends FormRequest
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
            'employee_id' => [
                'sometimes',
                'exists:employees,id',
            ],

            'customer_id' => [
                'nullable',
                'exists:customers,id',
            ],

            'start_time' => [
                'sometimes',
                'date',
            ],

            'duration_in_minutes' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'end_time' => [
                'sometimes',
                'date',
                'after:start_time',
            ],

            'total_price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'guest_count' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'status' => [
                'sometimes',
                new Enum(ReservationStatus::class),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'sometimes' => ':attribute is required.',
            'after' => ':attribute must be after start time.',
        ];
    }

    public function attributes(): array
    {
        return [
            'start_time' => 'start time',
            'end_time' => 'end time',
            'guest_count' => 'guest count',
        ];
    }
}
