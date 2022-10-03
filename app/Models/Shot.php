<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shot extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    public $table = 'shots';
    protected $fillable = ['user_id', 'media_url', 'title', 'description', 'content', 'view_type', 'status'];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'shot_id', 'id');
    }

    public function reacts()
    {
        return $this->hasMany(React::class, 'shot_id', 'id');
    }
}
