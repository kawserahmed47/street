<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class React extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    public $table = 'reacts';
    protected $fillable = ['user_id', 'shot_id', 'react'];

    public function shot()
    {
        return $this->belongsTo(Shot::class, 'shot_id', 'id');
    }
}
