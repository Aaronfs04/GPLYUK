<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role_id',
        'division_id',
        'position',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function managedDivisions()
    {
        return $this->hasMany(Division::class, 'manager_id');
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'created_by_id');
    }

    public function hasRole(string|array $roles): bool
    {
        $slug = $this->role?->slug;

        if (is_array($roles)) {
            return in_array($slug, $roles, true);
        }

        return $slug === $roles;
    }

    /**
     * Apakah user memegang peran manajerial / eksekutif
     */
    public function isManager(): bool
    {
        return $this->hasRole(['admin', 'ketua', 'sekretaris', 'bendahara']);
    }

    /**
     * Apakah user bisa mengelola dan melihat seluruh divisi (Ketua & Admin)
     */
    public function canManageAllDivisions(): bool
    {
        return $this->hasRole(['admin', 'ketua']);
    }

    /**
     * Apakah user berwenang mengelola divisi tertentu
     */
    public function canManageDivision(int|string $divisionId): bool
    {
        if ($this->canManageAllDivisions()) {
            return true;
        }

        return $this->managedDivisions()->where('id', $divisionId)->exists();
    }
}
