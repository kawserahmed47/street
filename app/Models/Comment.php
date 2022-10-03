<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    public $table = 'comments';
    protected $fillable = ['user_id', 'shot_id', 'message', 'status'];

    public function shot()
    {
        return $this->belongsTo(Shot::class, 'shot_id', 'id');
    }

    public function reply()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }


}
