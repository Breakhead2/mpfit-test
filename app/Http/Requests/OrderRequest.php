<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'min:5', 'max:255', 'regex:/^[А-Яа-яЁё\s\-]+$/u'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'comment' => ['nullable', 'string', 'min:5', 'max:1000']
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Поле "ФИО покупателя" обязательно для заполнения.',
            'full_name.string' => 'Поле "ФИО покупателя" должно быть текстовым.',
            'full_name.min' => 'Поле "ФИО покупателя" должно содержать минимум 5 символов.',
            'full_name.max' => 'Поле "ФИО покупателя" не должно превышать 255 символов.',
            'full_name.regex' => 'Поле "ФИО покупателя" может содержать только русские буквы, пробелы и дефисы.',

            'product_id.required' => 'Выберите товар.',
            'product_id.exists' => 'Выбранный товар не существует.',

            'quantity.required' => 'Поле "Количество" обязательно для заполнения.',
            'quantity.integer' => 'Поле "Количество" должно быть целым числом.',
            'quantity.min' => 'Минимальное количество товара — 1.',

            'comment.string' => 'Поле "Комментарий" должно быть текстовым.',
            'comment.max' => 'Поле "Комментарий" не должно превышать 1000 символов.',
            'comment.min' => 'Поле "Комментарий" должно содержать минимум 5 символов.',
        ];
    }

}
