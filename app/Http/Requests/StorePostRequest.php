<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'tags' => ['array'],
            'tags.*' => ['string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::user()->id, // Set the user_id as the authenticated user's ID
            'tags' => $this->input('tags', []),
        ]);
    }
}
