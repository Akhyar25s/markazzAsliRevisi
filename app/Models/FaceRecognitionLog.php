<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaceRecognitionLog extends Model
{
    use HasFactory;

    protected $table = 'face_recognition_log';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'jenis_absen',
        'referensi_id',
        'hasil',
        'latitude',
        'longitude',
        'scanned_at',
    ];

    protected function casts(): array
    {
        return [
            'scanned_at' => 'datetime',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
