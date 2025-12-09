<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'team_user')->withTimestamps();
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
