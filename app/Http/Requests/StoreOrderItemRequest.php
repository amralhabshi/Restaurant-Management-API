<?php

namespace App\Http\Requests;

use App\Enums\OrderItemType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreOrderItemRequest extends FormRequest
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

            'menu_item_id' => [
                'required',
                'exists:menu_items,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'type' => [
                'required',
                new Enum(OrderItemType::class),
            ],

        ];
    }
}
