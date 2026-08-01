<?php

namespace App\Http\Requests;

use App\Enums\DeliveryStatus;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreDeliveryRequest extends FormRequest
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
                'required',
                'string',
                'max:255',
            ],

            'customer_phone' => [
                'required',
                'string',
                'max:30',
            ],

            'customer_address' => [
                'required',
                'string',
            ],

            'delivery_address' => [
                'required',
                'string',
            ],

            'status' => [
                'required',
                new Enum(DeliveryStatus::class),
            ],

            'payment_status' => [
                'required',
                new Enum(PaymentStatus::class),
            ],

            'cash_collected' => [
                'required',
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
