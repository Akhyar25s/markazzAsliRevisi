<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KirimLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:150'],
            'jenis' => ['required', 'in:tanggal,kegiatan,nama_pengguna'],
            'filter_value' => ['nullable', 'string', 'max:100'],
            'dikirim_oleh' => ['required', 'integer', 'exists:users,id'],
            'diterima_oleh' => ['required', 'integer', 'exists:users,id', 'different:dikirim_oleh'],
            'file_path' => ['required', 'string', 'max:255'],
            'pesan' => ['nullable', 'string'],
        ];
    }
}
