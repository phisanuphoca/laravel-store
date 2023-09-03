<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255'],
      'phone' => ['required', 'string', 'max:10'],
      'address' => ['required', 'string', 'max:255'],
      'billing_address' => ['required', 'string', 'max:255'],
      'products' => ['required', 'array'],
      'products.*.id' => [
        'required',
        "exists:products"
      ],
      'products.*.quantity' => [
        'required',
        'numeric',
        'min:1'
      ]
    ];
  }
}
