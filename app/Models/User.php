<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Mapi\Easyapi\Models\ApiUser;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends ApiUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'roles', 'permissions'
    ];

    protected $allowedFilters = [
        'id'
    ];

    public function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Hash::make($value)
        );
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function getRole(): string
    {
        $role = $this->roles()->first(['id', 'name']);
        return $role?->name;
    }

    public function getPermissions(): array
    {
//        return $this->getAllPermissions()->map->only(['id','name'])->values()->toArray();
        return $this->getAllPermissions()->pluck('name')->toArray();
    }
}
