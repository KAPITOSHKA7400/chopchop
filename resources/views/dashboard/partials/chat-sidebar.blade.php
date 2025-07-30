@php
    $chats = $messages instanceof \Illuminate\Pagination\AbstractPaginator
        ? $messages->getCollection()
        : $messages;

    $sidebarChats = $chats->unique(fn($msg) => $msg->bot_token . '_' . $msg->chat_id);
@endphp

@foreach($sidebarChats as $chat)
    @php
        $tgUser = \App\Models\TgChatUser::where('user_id', $chat->telegram_user_id)->first();
        $avatar = $tgUser && $tgUser->avatar_url
            ? $tgUser->avatar_url
            : 'https://ui-avatars.com/api/?name=' . ($tgUser->username ?? 'User');

        $botObj = $bots->firstWhere('bot_token', $chat->bot_token);

        $active = request('chat_id') == $chat->chat_id ? 'bg-blue-100 dark:bg-blue-900' : 'bg-gray-200 dark:bg-gray-900';

        $lastMsg = $chats->where('chat_id', $chat->chat_id)->last();
    @endphp
        <a href="{{ route('dashboard.chats', array_merge(request()->all(), ['chat_id' => $chat->chat_id, 'bot_id' => $botObj->id ?? ''])) }}"
           class="flex items-center p-2 mb-1 rounded-lg cursor-pointer w-full {{ $active }}">
            <img src="{{ $avatar }}" class="w-10 h-10 md:w-14 md:h-14 rounded-[10px] mr-2" alt="avatar">
            <div class="w-full">
                <div class="font-bold flex items-center gap-1 text-[14px]">
                    {{ $tgUser->username ?? 'Пользователь' }}
                </div>
                <div class="flex justify-between">
                    <div class="text-xs text-gray-500 dark:text-gray-400 hidden md:block text-[10px]">Бот: {{ $botObj->bot_name ?? 'неизвестно' }}</div>
                    <div class="text-xs text-gray-400 dark:text-gray-500 hidden md:block text-[12px]">
                        {{ optional($lastMsg->created_at)->format('d.m.Y H:i') }}
                    </div>
                </div>
                <div class="whitespace-nowrap truncate max-w-[180px] overflow-hidden text-[14px]">
                    {{ $lastMsg->text ?? '' }}
                </div>
            </div>
        </a>
@endforeach
