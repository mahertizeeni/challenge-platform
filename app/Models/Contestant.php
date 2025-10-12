<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contestant extends Model
{
 protected $fillable = ['name','score','game_session_id'];
 public function gameSession()
 {
    return $this -> belongsTo(GameSession::class);
 }
}
