<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'name',
        'email',
        'password',
        'client_id',
        'current_client_id',
        'role',
        'is_active',
        'permissions',
        'avatar',
        'timezone',
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
            'role' => UserRole::class,
            'is_active' => 'boolean',
            'permissions' => 'array',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the client that owns the user (legacy - for backward compatibility).
     * @deprecated Use clients() relationship instead
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get all clients this user belongs to (many-to-many relationship).
     * Each user can belong to multiple clients with different roles and permissions.
     */
    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'client_user')
            ->withPivot(['role', 'permissions', 'is_primary', 'is_active'])
            ->withTimestamps()
            ->wherePivot('is_active', true);
    }

    /**
     * Get the currently selected client for this user.
     */
    public function currentClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'current_client_id');
    }

    /**
     * Get the user's primary client.
     */
    public function primaryClient()
    {
        return $this->clients()->wherePivot('is_primary', true)->first();
    }

    /**
     * Switch to a different client context.
     */
    public function switchClient(int $clientId): bool
    {
        // Verify user has access to this client
        if (!$this->clients()->where('clients.id', $clientId)->exists()) {
            return false;
        }

        $this->update(['current_client_id' => $clientId]);
        return true;
    }

    /**
     * Get the role for the current client context.
     */
    public function getCurrentRole(): ?UserRole
    {
        if (!$this->current_client_id) {
            return $this->role; // Fallback to user's default role
        }

        $pivot = $this->clients()->where('clients.id', $this->current_client_id)->first()?->pivot;

        if ($pivot && $pivot->role) {
            return UserRole::from($pivot->role);
        }

        return $this->role;
    }

    /**
     * Get the permissions for the current client context.
     */
    public function getCurrentPermissions(): array
    {
        if (!$this->current_client_id) {
            return $this->permissions ?? [];
        }

        $pivot = $this->clients()->where('clients.id', $this->current_client_id)->first()?->pivot;

        if ($pivot && $pivot->permissions) {
            return is_array($pivot->permissions) ? $pivot->permissions : json_decode($pivot->permissions, true);
        }

        return $this->permissions ?? [];
    }

    /**
     * Check if the user has a specific permission in the current client context.
     */
    public function hasPermission(string $permission): bool
    {
        // Get current client context permissions
        $currentPermissions = $this->getCurrentPermissions();

        // Check custom permissions first
        if (in_array($permission, $currentPermissions)) {
            return true;
        }

        // Check role-based permissions for current client context
        $currentRole = $this->getCurrentRole();
        return $currentRole ? $currentRole->hasPermission($permission) : false;
    }

    /**
     * Check if the user has any of the given permissions.
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if the user has all of the given permissions.
     */
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if the user has a specific role in the current client context.
     */
    public function hasRole(UserRole $role): bool
    {
        $currentRole = $this->getCurrentRole();
        return $currentRole === $role;
    }

    /**
     * Check if the user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include users for a specific client.
     */
    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Update the user's last login timestamp.
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }
}
