<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|min:10|max:15|unique:users',
            'alamat' => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * Custom messages
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'no_hp.required' => 'Nomor HP harus diisi.',
            'no_hp.regex' => 'Format nomor HP tidak valid. Gunakan format 08xxxx atau +628xxxx',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
