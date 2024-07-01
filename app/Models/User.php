<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    public function biodata()
    {
        return $this->hasOne(UserBiodata::class,'users_id','id');
    }

    public function education()
    {
        return $this->hasMany(UserEducation::class,'users_id','id');
    }

    public function training()
    {
        return $this->hasMany(UserTraining::class,'users_id','id');
    }

    public function work()
    {
        return $this->hasMany(UserWork::class,'users_id','id');
    }

    public function scopeFilter ($query, $filter)
    {
        return $query->when($filter->name ?? false, function($query) use ($filter) {
            return $query->where('name', 'like', "%$filter->name%");
        })->when($filter->education ?? false, function($query) use($filter) {
            return $query->whereHas('education',function($search) use($filter) {
                $search->where('last_education','like',"%$filter->education%");
            });
        });

    }
}
