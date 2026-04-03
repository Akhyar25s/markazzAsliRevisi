<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeaktifanAnggota extends Model
{
    use HasFactory;

    protected $table = 'keaktifan_anggota';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'jenis_kegiatan',
        'tanggal',
        'total_hadir',
        'total_kegiatan',
        'persentase',
        'periode',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'persentase' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
