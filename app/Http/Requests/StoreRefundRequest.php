<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRefundRequest extends FormRequest
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

            'refund_number' => [
                'required',
                'string',
                'max:100',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'reason' => [
                'required',
                'string',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'refunded_at' => [
                'required',
                'date',
            ],

        ];
    }
}
