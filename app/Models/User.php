<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'password',
        'role',
        'face_data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'created_at' => 'datetime',
        ];
    }

    public const UPDATED_AT = null;

    public function kelompokItikafDikelola(): HasMany
    {
        return $this->hasMany(KelompokItikaf::class, 'admin_jamaah_id');
    }

    public function amirItikaf(): HasMany
    {
        return $this->hasMany(AmirItikaf::class, 'user_id');
    }

    public function amirDitugaskan(): HasMany
    {
        return $this->hasMany(AmirItikaf::class, 'assigned_by');
    }

    public function anggotaKelompok(): HasMany
    {
        return $this->hasMany(AnggotaKelompok::class, 'user_id');
    }

    public function jadwalItikafDibuat(): HasMany
    {
        return $this->hasMany(JadwalItikaf::class, 'created_by');
    }

    public function absensiKegiatan(): HasMany
    {
        return $this->hasMany(AbsensiKegiatan::class, 'user_id');
    }

    public function absensiItikaf(): HasMany
    {
        return $this->hasMany(AbsensiItikaf::class, 'user_id');
    }

    public function keaktifanAnggota(): HasMany
    {
        return $this->hasMany(KeaktifanAnggota::class, 'user_id');
    }

    public function laporanDikirim(): HasMany
    {
        return $this->hasMany(Laporan::class, 'dikirim_oleh');
    }

    public function laporanDiterima(): HasMany
    {
        return $this->hasMany(Laporan::class, 'diterima_oleh');
    }

    public function notifikasiLaporan(): HasMany
    {
        return $this->hasMany(NotifikasiLaporan::class, 'user_id');
    }

    public function faceRecognitionLogs(): HasMany
    {
        return $this->hasMany(FaceRecognitionLog::class, 'user_id');
    }

    public function roleLogs(): HasMany
    {
        return $this->hasMany(RoleLog::class, 'user_id');
    }

    public function roleLogsDiubahOleh(): HasMany
    {
        return $this->hasMany(RoleLog::class, 'diubah_oleh');
    }

    public function deletedUsersLogs(): HasMany
    {
        return $this->hasMany(DeletedUsersLog::class, 'dihapus_oleh');
    }
}
