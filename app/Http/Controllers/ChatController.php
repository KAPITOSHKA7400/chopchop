<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bot;
use App\Models\ChatMessage;
use App\Models\User;

class ChatController extends Controller
{
    // Главная страница с чатами и фильтрами
    public function index(Request $request)
    {
        $userId = auth()->id();

        $bots = Bot::where('is_active', 1)
            ->where('user_id', $userId)
            ->get();

        $operators = User::where('role', 'operator')->get();

        $selectedBot = $request->bot_id ? Bot::find($request->bot_id) : null;

        $query = ChatMessage::query();

        if ($selectedBot) {
            $query->where('bot_token', $selectedBot->bot_token);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')
                    ->orWhere('telegram_user_id', $request->search);
            });
        }

        // Добавляй свои фильтры по приоритету, статусу решения, оператору здесь

        $messages = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 50);

        return view('dashboard.chats', compact('bots', 'operators', 'selectedBot', 'messages'));
    }

    // AJAX: список уникальных чатов для сайдбара
    public function chatList(Request $request)
    {
        $userId = auth()->id();

        $bots = Bot::where('user_id', $userId)->get();

        $query = ChatMessage::query();

        if ($request->bot_id) {
            $bot = Bot::find($request->bot_id);
            if ($bot) {
                $query->where('bot_token', $bot->bot_token);
            }
        }

        $messages = $query->orderBy('created_at')->get();

        return view('dashboard.partials.chat-sidebar', compact('messages', 'bots'));
    }

    // AJAX: сообщения выбранного чата
    public function chatMessages(Request $request)
    {
        $userId = auth()->id();

        $chatId = $request->chat_id;
        $botId = $request->bot_id;

        $botToken = null;
        if ($botId) {
            $bot = Bot::find($botId);
            $botToken = $bot ? $bot->bot_token : null;
        }

        $query = ChatMessage::query();

        if ($chatId) {
            $query->where('chat_id', $chatId);
        }
        if ($botToken) {
            $query->where('bot_token', $botToken);
        }

        $messages = $query->orderBy('created_at')->get();

        $bots = Bot::where('user_id', $userId)->get();

        return view('dashboard.partials.chat-messages', compact('messages', 'bots'));
    }
}
