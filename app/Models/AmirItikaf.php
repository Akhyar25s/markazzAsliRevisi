<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmirItikaf extends Model
{
    use HasFactory;

    protected $table = 'amir_itikaf';

    public const UPDATED_AT = null;

    protected $fillable = [
        'kelompok_id',
        'user_id',
        'assigned_by',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
