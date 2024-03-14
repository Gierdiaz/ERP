<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'unique:customers,email', 'max:255'],
            'phone'   => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
        ];

        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules = array_map(function ($rule) {
                return str_replace('required', 'sometimes', $rule);
            }, $rules);
        }

        return $rules;
    }
}
