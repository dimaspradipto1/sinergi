<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Dapatkan inisial nama pengguna.
     */
    public function getInitialsAttribute(): string
    {
        $name = trim($this->name ?? '');
        if (empty($name)) {
            return 'U';
        }

        $words = preg_split('/\s+/', $name);
        if (count($words) >= 2) {
            $first = mb_substr($words[0], 0, 1);
            $last = mb_substr(end($words), 0, 1);
            return mb_strtoupper($first . $last);
        }

        return mb_strtoupper(mb_substr($name, 0, 2));
    }
}
