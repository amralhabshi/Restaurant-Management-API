<?php

namespace App\Http\Requests;

use App\Enums\DeliveryStatus;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateDeliveryRequest extends FormRequest
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
                'nullable',
                'exists:employees,id',
            ],

            'delivery_zone_id' => [
                'nullable',
                'exists:delivery_zones,id',
            ],

            'customer_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'customer_phone' => [
                'sometimes',
                'string',
                'max:30',
            ],

            'customer_address' => [
                'sometimes',
                'string',
            ],

            'delivery_address' => [
                'sometimes',
                'string',
            ],

            'status' => [
                'sometimes',
                new Enum(DeliveryStatus::class),
            ],

            'payment_status' => [
                'sometimes',
                new Enum(PaymentStatus::class),
            ],

            'cash_collected' => [
                'sometimes',
                'boolean',
            ],

            'picked_up_at' => [
                'nullable',
                'date',
            ],

            'delivered_at' => [
                'nullable',
                'date',
            ],

        ];
    }
}
