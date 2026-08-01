<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdatePaymentRequest extends FormRequest
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

            'amount' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'method' => [
                'sometimes',
                new Enum(PaymentMethod::class),
            ],

            'status' => [
                'sometimes',
                new Enum(PaymentStatus::class),
            ],

            'paid_at' => [
                'nullable',
                'date',
            ],

        ];
    }
}
