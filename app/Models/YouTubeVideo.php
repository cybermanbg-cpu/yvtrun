<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YouTubeVideo extends Model
{
    protected $table = 'youtube_videos';
    
    protected $fillable = [
        'title', 'youtube_id', 'thumbnail', 'is_live', 'is_active', 'scheduled_at'
    ];
    
    protected $casts = [
        'is_live' => 'boolean',
        'is_active' => 'boolean',
        'scheduled_at' => 'datetime'
    ];
    
    public function getEmbedUrlAttribute()
    {
        if ($this->is_live) {
            return "https://www.youtube.com/embed/{$this->youtube_id}?autoplay=1&mute=0";
        }
        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }
}