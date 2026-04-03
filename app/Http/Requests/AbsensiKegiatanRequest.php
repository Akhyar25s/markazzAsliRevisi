<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsensiKegiatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'jenis_kegiatan' => ['required', 'in:kunjungan_guru,kunjungan_pelmas,duduk_talim_masjid,hadir_malam_markaz'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'in:hadir,tidak_hadir,izin'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'verified' => ['nullable', 'boolean'],
        ];
    }
}
