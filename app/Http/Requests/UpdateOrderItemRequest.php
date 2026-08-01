<?php

namespace App\Http\Requests;

use App\Enums\OrderItemType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderItemRequest extends FormRequest
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
                'sometimes',
                'exists:menu_items,id',
            ],

            'quantity' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'unit_price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'type' => [
                'sometimes',
                new Enum(OrderItemType::class),
            ],

        ];
    }
}
