<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalItikaf extends Model
{
    use HasFactory;

    protected $table = 'jadwal_itikaf';

    public const UPDATED_AT = null;

    protected $fillable = [
        'kelompok_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'created_by',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(KelompokItikaf::class, 'kelompok_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function absensiItikaf(): HasMany
    {
        return $this->hasMany(AbsensiItikaf::class, 'jadwal_itikaf_id');
    }
}
