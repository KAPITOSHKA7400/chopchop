@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        @include('partials.dashboard-menu')

        {{-- Форма добавления бота --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
            <form action="#" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
                @csrf
                <div class="w-full md:w-1/4">
                    <label for="bot_name" class="block text-gray-700 dark:text-gray-200 mb-1">Имя бота</label>
                    <input type="text" name="bot_name" id="bot_name" required
                           class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-blue-400">
                </div>
                <div class="flex-1">
                    <label for="bot_token" class="block text-gray-700 dark:text-gray-200 mb-1">Токен бота</label>
                    <input type="text" name="bot_token" id="bot_token" required
                           class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-blue-400">
                </div>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Добавить бота</button>
            </form>
        </div>

        {{-- Список ботов --}}
        @if(isset($bots) && count($bots))
            <div class="space-y-4">
                @foreach($bots as $bot)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow flex flex-col md:flex-row items-center md:items-stretch p-4 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center flex-1 min-w-0">
                        <span class="inline-flex items-center mr-3">
                            <span class="w-4 h-4 rounded-full mr-2 border-2 border-white dark:border-gray-800
                                {{ $bot->is_active ? 'bg-green-500' : 'bg-red-500' }}">
                            </span>
                        </span>
                            <span class="truncate text-lg font-medium text-gray-900 dark:text-gray-100 mr-2">
                            {{ $bot->bot_name }}
                        </span>
                            <span class="truncate text-gray-500 dark:text-gray-400 text-base">
                            ({{ $bot->bot_username }})
                        </span>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-4 md:mt-0 md:ml-6">
                            <a href="#" class="px-4 py-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">Наборы сообщений</a>
                            <a href="#" class="px-4 py-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">Редактировать</a>
                            <a href="#" class="px-4 py-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">Статистика</a>
                            <a href="#" class="px-4 py-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">Скопировать приглашение</a>
                            <a href="#" class="px-4 py-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">Скопировать запрос для группы</a>
                            <form action="{{ route('bot.destroy', $bot->id) }}" method="POST" class="inline" onsubmit="return confirm('Удалить бота &laquo;{{ $bot->bot_name }}&raquo;?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        @else
            <div class="text-center text-gray-500 dark:text-gray-400 py-12">
                У вас пока нет добавленных ботов.<br>
                Используйте форму выше, чтобы добавить первого бота!
            </div>
        @endif
    </div>
@endsection
