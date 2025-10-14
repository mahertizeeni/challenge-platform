<?php

namespace App\Http\Controllers;

use App\Models\GameSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Container\Attributes\Auth as AttributesAuth;

class UserProfileCpntroller extends Controller
{
    public function index (Request $request)
    {
        $games = GameSession::where('created_by',Auth::id())->get();
        return view('Profile',compact('games'));
    }

}
