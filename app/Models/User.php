<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define constants for role IDs
    const ROLE_ADMIN = 1;
    const ROLE_UMAT = 2;
    const ROLE_SUPER_ADMIN = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        
        'username',
        'email',
        'phone',
        'password',
        'google_id',
        'google_token',
        'google_refresh_token',
        'role_id', // tambahkan role_id ke fillable jika Anda ingin mengisinya secara eksplisit
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'string', // ganti 'hashed' menjadi 'string' untuk penggunaan default Laravel bcrypt
    ];

    /**
     * Default attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'role_id' => self::ROLE_UMAT, // role_id default
    ];

    /**
     * Get the role name.
     *
     * @return string
     */
    public function getRoleAttribute(): string
    {
        switch ($this->role_id) {
            case self::ROLE_ADMIN:
                return 'Admin';
            case self::ROLE_UMAT:
                return 'Umat';
            case self::ROLE_SUPER_ADMIN:
                return 'Super Admin';
            default:
                return 'Undefined';
        }
    }
    // Contoh definisi relasi di dalam model User
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'user_id', 'id');
    }
}
