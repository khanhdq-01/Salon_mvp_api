<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'token_version',
        'phone',
        'status',
        'last_login'
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

        public function getJWTCustomClaims()
    {
        return [
            'token_version' => $this->token_version,
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function setPasswordHashAttribute($value)
    {
        $this->attributes['password'] = $value;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            if (!isset($model->token_version)) {
                $model->token_version = 0;
            }
        });
    }
}