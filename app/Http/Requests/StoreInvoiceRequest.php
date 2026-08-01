<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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

            'invoice_number' => [
                'required',
                'string',
                'max:100',
            ],

            'subtotal' => [
                'required',
                'numeric',
                'min:0',
            ],

            'tax' => [
                'required',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'total' => [
                'required',
                'numeric',
                'min:0',
            ],

            'issued_at' => [
                'nullable',
                'date',
            ],

        ];
    }
}
