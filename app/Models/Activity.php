<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $primaryKey = 'activity_id';
    
    protected $fillable = [
        'judul_aktivitas',
        'divisi',
        'unit', 
        'catatan',
        'foto',
        'user_id'
    ];

    protected $casts = [
        'foto' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'activity_id', 'activity_id');
    }

    public function getRouteKeyName()
    {
        return 'activity_id';
    }

    public function getFotoPathsAttribute()
    {
        if (empty($this->foto)) {
            return [];
        }
        if (is_array($this->foto)) {
            return array_map(function($photo) {
                return asset('storage/' . $photo);
            }, $this->foto);
        }
    }
}