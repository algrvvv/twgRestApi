<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null ?? $user->tokenCan('post:update', 'post:delete');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $mehod = $this->method();

        if ($mehod == 'PUT') {
            return [
                'title' => ['required', 'min:3'],
                'conent' => ['required', 'min:3']
            ];
        } else {
            return [
                'title' => ['sometimes', 'required', 'min:3'],
                'conent' => ['sometimes', 'required', 'min:3']
            ];
        }
    }
}
