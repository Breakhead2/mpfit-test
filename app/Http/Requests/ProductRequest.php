<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'regex:/^\d{1,6}([.,]\d{1,2})?$/']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Название" обязательно для заполнения.',
            'name.string' => 'Поле "Название" должно быть текстовым.',
            'name.max' => 'Поле "Название" не должно превышать 255 символов.',
            'name.min' => 'Поле "Название" не должно быть меньше 5 символов.',

            'category_id.required' => 'Выберите категорию.',
            'category_id.exists' => 'Выбранная категория не существует.',

            'description.string' => 'Поле "Описание" должно быть текстовым.',
            'description.max' => 'Поле "Описание" не должно превышать 1000 символов.',

            'price.required' => 'Поле "Цена" обязательно для заполнения.',
            'price.numeric' => 'Поле "Цена" должно быть числом.',
            'price.regex' => 'Формат поля "Цена" некорректен. Введите сумму в формате "123.45" или "123,45".',
        ];
    }

}
