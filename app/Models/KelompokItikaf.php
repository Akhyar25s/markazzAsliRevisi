<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokItikaf extends Model
{
    use HasFactory;

    protected $table = 'kelompok_itikaf';

    public const UPDATED_AT = null;

    protected $fillable = [
        'nama_kelompok',
        'admin_jamaah_id',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function adminJamaah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_jamaah_id');
    }

    public function amirItikaf(): HasMany
    {
        return $this->hasMany(AmirItikaf::class, 'kelompok_id');
    }

    public function anggotaKelompok(): HasMany
    {
        return $this->hasMany(AnggotaKelompok::class, 'kelompok_id');
    }

    public function jadwalItikaf(): HasMany
    {
        return $this->hasMany(JadwalItikaf::class, 'kelompok_id');
    }
}
