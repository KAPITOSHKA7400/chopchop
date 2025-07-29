<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bot;
use App\Models\User;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $bots = \App\Models\Bot::where('user_id', auth()->id())->get();
        $operators = \App\Models\User::where('role', 'operator')->get(); // Вот что нужно

        return view('dashboard.chats', compact('bots', 'operators'));
    }


}
