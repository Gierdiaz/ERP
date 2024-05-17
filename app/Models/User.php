<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use HasUuids;
    use HasRoles;

    protected $table = 'users';

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'language',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'profile_id');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'user_id');
    }

}
