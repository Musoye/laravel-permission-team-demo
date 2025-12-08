<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
       protected $fillable = [
        'team_id',
        'user_id',
        'title',
        'content'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
