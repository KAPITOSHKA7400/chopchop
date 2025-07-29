<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $bots = Bot::where('user_id', Auth::id())->get();
        return view('dashboard', compact('bots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bot_name'   => 'required|string|max:50',
            'bot_token'  => 'required|string|unique:bots,bot_token',
        ]);

        // Получаем username из Telegram API
        $response = @file_get_contents("https://api.telegram.org/bot{$request->bot_token}/getMe");
        $data = @json_decode($response, true);

        if (empty($data['ok']) || empty($data['result']['username'])) {
            return back()->withErrors(['bot_token' => 'Не удалось получить username через токен. Проверьте токен!'])->withInput();
        }

        $bot = Bot::create([
            'user_id'      => Auth::id(),
            'bot_token'    => $request->bot_token,
            'bot_name'     => $request->bot_name,
            'bot_username' => $data['result']['username'],
            'is_active'    => true,
        ]);

        return redirect()->route('dashboard');
    }

    public function destroy(\App\Models\Bot $bot)
    {
        // Только владелец может удалить!
        if ($bot->user_id !== auth()->id()) {
            abort(403);
        }
        $bot->delete();
        return redirect()->route('dashboard')->with('success', 'Бот удалён.');
    }
}
