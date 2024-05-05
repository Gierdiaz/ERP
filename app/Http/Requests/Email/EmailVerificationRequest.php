<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class EmailVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * @return array<mixed>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
