<?php

namespace App\Http\Requests\Api\Domain\Json;

use Illuminate\Foundation\Http\FormRequest;

class IssuerRequest extends FormRequest
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
            'data.issuer.name' => 'required',
            'data.issuer.identityProof' => ['required', 'array:type,key,location'],
        ];
    }
}
