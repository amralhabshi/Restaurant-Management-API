<?php

namespace App\Http\Requests;

use App\Enums\ReservationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreReservationRequest extends FormRequest
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
                'required',
                'exists:employees,id',
            ],

            'customer_id' => [
                'nullable',
                'exists:customers,id',
            ],

            'start_time' => [
                'required',
                'date',
            ],

            'duration_in_minutes' => [
                'required',
                'integer',
                'min:1',
            ],

            'end_time' => [
                'required',
                'date',
                'after:start_time',
            ],

            'total_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'guest_count' => [
                'required',
                'integer',
                'min:1',
            ],

            'status' => [
                'required',
                new Enum(ReservationStatus::class),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required.',
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
