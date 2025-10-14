<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Contestant;
use App\Models\GameSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameSessionController extends Controller
{
 public function create ()
 {
    return view('game_sessions.create');
 }

    public function store(Request $request)
    {
        $request->validate([
            'game_name' => 'required|string|max:255',
            'players' => 'required|array|min:1',
            'players.*' => 'required|string|max:255',
        ]);

        $gameSession = GameSession::create([
            'name' => $request->game_name,
            'created_by' => Auth::id(),
        ]);

        foreach ($request->players as $playerName) {
            Contestant::create([
                'name' => $playerName,
                'game_session_id' => $gameSession->id,
            ]);
        }

        return redirect()->route('game_sessions.play', $gameSession->id);
    }


    public function play(GameSession $gameSession)
{
    $contestants = $gameSession->contestants;

     if ($gameSession->created_by !== auth::id()) {
        abort(403, '❌ لا يمكنك الدخول إلى جلسة لا تخصك.');
    }

    
    $questions = Question::paginate(5);

    return view('game_sessions.play', compact('gameSession', 'contestants', 'questions'));
}



    public function updateScore(Request $request, Contestant $contestant)
    {
        $contestant->update(['score' => $request->score]);
        return response()->json(['success' => true, 'score' => $contestant->score]);
    }
}
