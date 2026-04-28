<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'last_login_at',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function createdAuthors(): HasMany
    {
        return $this->hasMany(Author::class, 'created_by_admin_id');
    }

    public function archivedArticles(): HasMany
    {
        return $this->hasMany(Article::class, 'archived_by_admin_id');
    }

    public function readContactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class, 'read_by_admin_id');
    }

    public function createdBanners(): HasMany
    {
        return $this->hasMany(Banner::class, 'created_by_admin_id');
    }

    public function updatedBanners(): HasMany
    {
        return $this->hasMany(Banner::class, 'updated_by_admin_id');
    }
}