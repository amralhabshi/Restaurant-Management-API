<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderRequest extends FormRequest
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

            'table_id' => [
                'nullable',
                'exists:tables,id',
            ],

            'reservation_id' => [
                'nullable',
                'exists:reservations,id',
            ],

            'order_number' => [
                'sometimes',
                'string',
                'max:100',
            ],

            'type' => [
                'sometimes',
                new Enum(OrderType::class),
            ],

            'status' => [
                'sometimes',
                new Enum(OrderStatus::class),
            ],

            'total_price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

        ];
    }
}
