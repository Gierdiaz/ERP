<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'file|max:2048|nullable|mimes:jpeg,png,jpg,gif,pdf,doc,docx,txt',
        ];
    }
}
