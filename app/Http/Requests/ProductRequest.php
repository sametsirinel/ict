<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use App\Rules\ChangeTurkishCharToEnglish;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

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
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', "string", "max:200", new ChangeTurkishCharToEnglish()],
            'description' => ['required', 'string', "max:200"],
            'stock_status' => ['nullable', 'boolean'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        // 500 hatası düzeltmeleri 
        // Mesaj metni önemli değilse bu alan olmadanda aynı sonucu alabiliriz.
        throw new ValidationException($validator->errors()->toArray());
    }
}
