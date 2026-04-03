<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiItikaf extends Model
{
    use HasFactory;

    protected $table = 'absensi_itikaf';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'jadwal_itikaf_id',
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

    public function jadwalItikaf(): BelongsTo
    {
        return $this->belongsTo(JadwalItikaf::class, 'jadwal_itikaf_id');
    }
}
