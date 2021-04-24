<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    Protected $guard_name ='web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * @param $role
     */
    public function asignarRol($role): void
    {
        $this->roles()
            ->sync($role, false);
    }

    /**
     * @return mixed
     */
    public function tieneRol()
    {
        return $this->roles
            ->flatten()
            ->pluck('name')
            ->unique();
    }

    /**
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%$search%");
        }
    }

    /**
     * @param $query
     * @param $role
     */
    public function scopeRole($query, $role)
    {
        if (empty($role)) {
            return;
        }

        return  $query->whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        });
    }
}
