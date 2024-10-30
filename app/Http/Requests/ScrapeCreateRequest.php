<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ScrapeCreateRequest extends FormRequest
{
    const URLS = 'urls';
    const SELECTORS = 'selectors';
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // let everyone scrape!
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            self::URLS => 'required|array|min:1',
            self::URLS . '.*' => 'required|url',
            self::SELECTORS => 'required|array|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'urls.required' => 'At least one URL is required.',
            'urls.*.url' => 'Each item in URLs must be a valid URL.',
            'selectors.required' => 'Selectors array is required.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'errors' => $validator->errors(),
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
