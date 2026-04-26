<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_id', 'category_id', 'title', 'slug', 'body', 
        'status', 'published_at', 'submitted_at', 'views_count', 
        'draft_origin', 'restore_to_status', 'restore_published_at', 
        'archived_by_admin_id', 'archived_at', 'cover_image'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'submitted_at' => 'datetime',
        'restore_published_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

