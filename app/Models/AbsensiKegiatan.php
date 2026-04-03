<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiKegiatan extends Model
{
    use HasFactory;

    protected $table = 'absensi_kegiatan';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'jenis_kegiatan',
        'tanggal',
        'status',
        'latitude',
        'longitude',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'verified_at' => 'datetime',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
