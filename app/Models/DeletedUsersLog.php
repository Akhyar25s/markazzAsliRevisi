<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeletedUsersLog extends Model
{
    use HasFactory;

    protected $table = 'deleted_users_log';

    public $timestamps = false;

    protected $fillable = [
        'user_id_lama',
        'nama',
        'no_hp',
        'role',
        'dihapus_oleh',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function dihapusOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dihapus_oleh');
    }
}
