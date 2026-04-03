<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    public const UPDATED_AT = null;

    protected $fillable = [
        'judul',
        'jenis',
        'filter_value',
        'dikirim_oleh',
        'diterima_oleh',
        'status',
        'file_path',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function dikirimOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dikirim_oleh');
    }

    public function diterimaOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diterima_oleh');
    }

    public function notifikasiLaporan(): HasMany
    {
        return $this->hasMany(NotifikasiLaporan::class, 'laporan_id');
    }
}
