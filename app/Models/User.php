<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    # use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'license_number',
        'medical_certificate_expiry',
        'phone',
        'is_active',
        'doc_number',
        'profile_photo',
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

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    /**
     * Las aeronaves asociadas al piloto.
     */
    public function aircrafts()
    {
        return $this->belongsToMany(Aircraft::class, 'aircraft_user')
                    ->withTimestamps(); // Para rastrear cuándo se asoció
    }

    /**
     * Los aeropuertos (privados o públicos) asociados al piloto.
     */
    public function airports()
    {
        return $this->belongsToMany(Airport::class, 'airport_user')
                    ->withTimestamps();
    }
}
