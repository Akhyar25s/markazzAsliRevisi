<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignAmirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelompok_id' => ['required', 'integer', 'exists:kelompok_itikaf,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'assigned_by' => ['required', 'integer', 'exists:users,id'],
            'tanggal_mulai' => ['required', 'date'],
            'durasi_hari' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
