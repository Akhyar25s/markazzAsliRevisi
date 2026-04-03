<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsensiItikafRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'jadwal_itikaf_id' => ['required', 'integer', 'exists:jadwal_itikaf,id'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'in:hadir,tidak_hadir'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'verified' => ['nullable', 'boolean'],
        ];
    }
}
