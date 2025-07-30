@php
    $currentChatId = request('chat_id');
    $currentBotId = request('bot_id');

    $currentBot = $bots->firstWhere('id', $currentBotId);

    $currentMessages = $messages->where('chat_id', $currentChatId);

    $firstMsg = $currentMessages->first();

    $tgUser = $firstMsg ? \App\Models\TgChatUser::where('user_id', $firstMsg->telegram_user_id)->first() : null;

    $avatar = $tgUser && $tgUser->avatar_url
        ? $tgUser->avatar_url
        : 'https://ui-avatars.com/api/?name=' . ($tgUser->username ?? 'User');
@endphp

<div class="flex-1 flex flex-col">
    {{-- Заголовок --}}
    <div class="flex p-2 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center border-gray-200 dark:border-gray-700">
            <img src="{{ $avatar }}" class="w-8 h-8 md:w-10 md:h-10 rounded-[10px] mr-2" alt="avatar">
            <span class="flex flex-col">
                <span class="font-bold text-base md:text-lg text-blue-700 dark:text-blue-400">
                    {{ $tgUser->username ?? 'Пользователь' }}
                </span>
                <span class="font-bold text-xs text-gray-500">Бот: {{ $currentBot->bot_name ?? 'неизвестно' }}</span>
            </span>
        </div>
    </div>

    {{-- Сообщения --}}
    <div class="flex-1 gap-2 min-h-[550px] overflow-y-auto p-2 space-y-2 md:space-y-4 bg-white dark:bg-gray-900">
        @forelse($currentMessages as $msg)
            <div class="relative text-xs md:text-sm
                {{ $msg->telegram_user_id == ($tgUser->user_id ?? null) ? 'bg-gray-100 dark:bg-gray-800' : 'bg-blue-50 dark:bg-blue-900' }}
                px-2 md:px-4 py-2 rounded-lg max-w-full">
                <span class="flex flex-col">
                    <span class="font-semibold {{ $msg->telegram_user_id == ($tgUser->user_id ?? null) ? 'text-gray-600 dark:text-gray-300' : 'text-blue-800 dark:text-blue-300' }}">
                        {{ $msg->username ?? 'Пользователь' }}
                    </span>
                    <span>{{ $msg->text }}</span>
                </span>
                <span class="flex flex-col absolute right-2 bottom-2">
                    <span class="text-xs text-gray-400 float-right ml-2">
                        {{ optional($msg->created_at)->format('H:i') }}
                    </span>
                </span>
            </div>
        @empty
            <div class="text-gray-400 italic">Нет сообщений в этом чате</div>
        @endforelse
    </div>
</div>
