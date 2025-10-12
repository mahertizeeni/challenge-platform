<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $fillable = ['name','created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    public function contestants()
    {
        return $this->hasMany(Contestant::class);
    }

}
