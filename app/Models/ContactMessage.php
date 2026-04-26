<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name', 'email', 'subject', 'message', 
        'is_read', 'read_at', 'read_by_admin_id'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function readBy()
    {
        return $this->belongsTo(Admin::class, 'read_by_admin_id');
    }
}
