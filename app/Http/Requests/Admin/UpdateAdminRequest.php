<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Admin|null $admin */
        $admin = $this->route('admin');

        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email',
                'max:191',
                Rule::unique('admins', 'email')->ignore($admin?->id),
            ],
            'password' => ['nullable', 'string'],
            'avatar' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
        ];
    }
}
