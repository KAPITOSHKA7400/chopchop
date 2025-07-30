@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        @include('partials.dashboard-menu')
        <div class="max-h-screen h-full p-6 bg-white dark:bg-gray-900 rounded shadow">

            {{-- Фильтр --}}
            <form method="GET" class="flex gap-2 mb-6 flex-wrap">
                {{-- Боты --}}
                <div>
                    <label class="block text-xs text-gray-500">Боты</label>
                    <select name="bot_id" class="w-40 px-3 py-2 border rounded bg-white dark:bg-gray-800">
                        <option value="">Все</option>
                        @foreach($bots as $bot)
                            <option value="{{ $bot->id }}" {{ request('bot_id') == $bot->id ? 'selected' : '' }}>
                                {{ $bot->bot_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Статус важности --}}
                <div>
                    <label class="block text-xs text-gray-500">Статус важности</label>
                    <select name="priority" class="w-40 px-3 py-2 border rounded bg-white dark:bg-gray-800">
                        <option value="">Все</option>
                        <option value="important" {{ request('priority') == 'important' ? 'selected' : '' }}>Важные</option>
                        <option value="not_important" {{ request('priority') == 'not_important' ? 'selected' : '' }}>Неважные</option>
                    </select>
                </div>

                {{-- Статус решения --}}
                <div>
                    <label class="block text-xs text-gray-500">Статус решения</label>
                    <select name="is_solved" class="w-40 px-3 py-2 border rounded bg-white dark:bg-gray-800">
                        <option value="">Все</option>
                        <option value="1" {{ request('is_solved') === '1' ? 'selected' : '' }}>Решённые</option>
                        <option value="0" {{ request('is_solved') === '0' ? 'selected' : '' }}>Нерешённые</option>
                    </select>
                </div>

                {{-- Ответственный --}}
                <div>
                    <label class="block text-xs text-gray-500">Ответственный</label>
                    <select name="operator_id" class="w-40 px-3 py-2 border rounded bg-white dark:bg-gray-800">
                        <option value="">Все</option>
                        @foreach($operators as $operator)
                            <option value="{{ $operator->id }}" {{ request('operator_id') == $operator->id ? 'selected' : '' }}>
                                {{ $operator->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Поиск (Ник или ID) --}}
                <div>
                    <label class="block text-xs text-gray-500">Поиск (Telegram)</label>
                    <input name="search" type="text" placeholder="Ник или Telegram ID"
                           value="{{ request('search') }}"
                           class="w-48 px-3 py-2 border rounded bg-white dark:bg-gray-800 truncate">
                </div>

                {{-- На странице --}}
                <div>
                    <label class="block text-xs text-gray-500">На странице</label>
                    <select name="per_page" class="w-24 px-3 py-2 border rounded bg-white dark:bg-gray-800">
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
                    </select>
                </div>

                {{-- Кнопка --}}
                <div class="flex items-end">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Обновить
                    </button>
                </div>
            </form>

            <h1 class="text-2xl font-bold mb-4">Чаты</h1>

            <div class="flex flex-col md:flex-row bg-gray-50 dark:bg-gray-800 rounded-xl shadow overflow-hidden mb-4">
                {{-- Сайдбар --}}
                <aside class="w-full md:w-[25rem] border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-700 flex flex-row md:flex-col">
                    <div class="flex-1 flex md:flex-col gap-1 p-1 md:p-2">
                        <div class="flex items-center md:items-start p-2 bg-gray-200 dark:bg-gray-900 rounded-lg cursor-pointer w-full">
                            <img src="https://ui-avatars.com/api/?name=Fragment" class="w-10 h-10 md:w-14 md:h-14 rounded-[10px] mr-2" alt="avatar">
                            <div class="w-full">
                                <div class="font-bold flex items-center gap-1 text-[14px]">
                                    <span class="text-blue-500 dark:text-blue-400">🔥</span> Mr/. Fragment
                                </div>
                                <div class="flex justify-between">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 hidden md:block text-[10px]">Бот: {{ $bot->bot_name }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 hidden md:block text-[12px]">07/29/2025 16:41</div>
                                </div>
                                <div class="whitespace-nowrap truncate max-w-[180px] overflow-hidden text-[14px]">Какое то последнее сообщение в чате</div>
                            </div>
                        </div>
                        <div class="flex items-center md:items-start p-2 hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer w-full">
                            <img src="https://ui-avatars.com/api/?name=KAPITOSHKА" class="w-10 h-10 md:w-14 md:h-14 rounded-[10px] mr-2" alt="avatar">
                            <div class="w-full">
                                <div class="font-bold flex items-center gap-1 text-[14px]">
                                    <span class="text-blue-500 dark:text-blue-400">✔</span> KAPITOSHKA™
                                </div>
                                <div class="flex justify-between">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 hidden md:block text-[10px]">Бот: {{ $bot->bot_name }}</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 hidden md:block text-[12px]">07/29/2025 16:41</div>
                                </div>
                                <div class="whitespace-nowrap truncate max-w-[180px] overflow-hidden text-[12px]">Какое то последнее сообщение в чате</div>
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- Основная часть чата --}}
                <main class="flex-1 flex flex-col" x-data="{ tab: 'dialog' }">
                    {{-- Верхние вкладки и фильтр --}}
                    <div class="flex items-center p-2 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex gap-2 w-full md:w-auto">
                            <button
                                @click="tab = 'dialog'"
                                :class="tab === 'dialog'
                                    ? 'text-blue-700 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 bg-white dark:bg-gray-800'
                                    : 'text-gray-600 dark:text-gray-300 hover:bg-white hover:dark:bg-gray-700'"
                                class="px-3 py-2 font-medium rounded-t text-xs md:text-base transition"
                            >Диалог</button>
                            <button
                                @click="tab = 'history'"
                                :class="tab === 'history'
                                    ? 'text-blue-700 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 bg-white dark:bg-gray-800'
                                    : 'text-gray-600 dark:text-gray-300 hover:bg-white hover:dark:bg-gray-700'"
                                class="px-3 py-2 font-medium rounded-t text-xs md:text-base transition"
                            >История</button>
                            <button
                                @click="tab = 'notes'"
                                :class="tab === 'notes'
                                    ? 'text-blue-700 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 bg-white dark:bg-gray-800'
                                    : 'text-gray-600 dark:text-gray-300 hover:bg-white hover:dark:bg-gray-700'"
                                class="px-3 py-2 font-medium rounded-t text-xs md:text-base transition"
                            >Заметки</button>
                            <button
                                @click="tab = 'user'"
                                :class="tab === 'user'
                                    ? 'text-blue-700 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400 bg-white dark:bg-gray-800'
                                    : 'text-gray-600 dark:text-gray-300 hover:bg-white hover:dark:bg-gray-700'"
                                class="px-3 py-2 font-medium rounded-t text-xs md:text-base transition"
                            >Пользователь</button>
                        </div>
                    </div>

                    {{-- Заголовок чата --}}
                    <div class="flex p-2 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center border-gray-200 dark:border-gray-700">
                            <img src="https://ui-avatars.com/api/?name=KAPITOSHKА" class="w-8 h-8 md:w-10 md:h-10 rounded-[10px] mr-2" alt="avatar">
                            <span class="flex flex-col">
                            <span class="font-bold text-base md:text-lg text-blue-700 dark:text-blue-400">KAPITOSHKA™</span>
                            <span class="font-bold text-xs text-gray-500">Бот: {{ $bot->bot_name }}</span>
                        </span>
                        </div>
                        <div class="w-full md:w-fit mt-2 md:mt-0 md:ml-auto flex gap-2">
                            <select class="w-[145px] h-[45px] rounded border border-gray-300 dark:border-gray-700 px-2 py-1 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 text-xs md:text-base">
                                <option>{{ $bot->owner->name ?? 'неизвестно' }}</option>
                            </select>
                            <button class="whitespace-nowrap bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition text-xs md:text-base">Назначить ответственным</button>
                        </div>
                    </div>

                    {{-- TAB CONTENT --}}
                    <div class="flex-1 gap-2 min-h-[550px] overflow-y-auto p-2 space-y-2 md:space-y-4 bg-white dark:bg-gray-900">
                        <div x-show="tab === 'dialog'" class="flex flex-col gap-2">
                            <div class="relative text-xs md:text-sm bg-gray-100 dark:bg-gray-800 px-2 md:px-4 py-2 rounded-lg max-w-full italic">
                                <span class="flex">
                                    <span class="flex flex-col w-full">
                                        <span class="font-semibold text-gray-600 dark:text-gray-300">пользователь</span>
                                        <span>/start</span>
                                    </span>
                                    <span class="text-xs text-gray-400 float-right ml-2">16:29</span>
                                </span>
                            </div>
                            <div class="relative text-xs md:text-sm bg-green-50 dark:bg-green-900 px-2 md:px-4 py-2 rounded-lg max-w-full">
                                <span class="flex flex-col">
                                    <span class="font-semibold text-green-800 dark:text-green-400">Автоматический ответ</span>
                                    <span>Напишите свой вопрос и мы ответим вам в ближайшее время!</span>
                                </span>
                                <span class="flex flex-col absolute right-2 bottom-2 ">
                                    <span class="text-xs text-gray-400 float-right ml-2">16:29</span>
                                </span>
                            </div>
                            @foreach([['sdfsdf'], ['Для того чтобы поделиться номером телефона, нажмите кнопку внизу \'Поделиться номером телефона\' на виртуальной клавиатуре'], ['Напишите свой вопрос и мы ответим вам в ближайшее время!'], ['В данный момент мы не можем вам ответить. Режим работы с 8:00 до 18:00.']] as $msg)
                                <div class="relative text-xs md:text-sm bg-blue-50 dark:bg-blue-900 px-2 md:px-4 py-2 rounded-lg max-w-full">
                                    <span class="flex flex-col">
                                        <span class="font-semibold text-blue-800 dark:text-blue-300">{{ $bot->owner->name ?? 'неизвестно' }}</span>
                                        <span>{{ $msg[0] }}</span>
                                    </span>
                                    <span class="flex flex-col absolute right-2 bottom-2 ">
                                        <span class="text-xs text-gray-400 float-right ml-2">16:41</span>
                                        <span class="flex gap-2">
                                            <button class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-300 text-xs">✎</button>
                                            <button class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 text-xs">🗑</button>
                                        </span>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <div x-show="tab === 'history'" x-cloak>
                            {{-- Здесь будет история чата --}}
                            <div class="text-gray-400 text-sm">Здесь будет история о пользователе. Заметки и номер #тикета/заказа.</div>
                        </div>
                        <div x-show="tab === 'notes'" x-cloak>
                            {{-- Здесь будут заметки --}}
                            <div class="text-gray-400 text-sm">Здесь будут заметки.</div>
                        </div>
                        <div x-show="tab === 'user'" x-cloak>
                            {{-- Здесь информация о пользователе --}}
                            <div class="text-gray-400 text-sm">Информация о пользователе.</div>
                        </div>
                    </div>

                    {{-- Поле ввода --}}
                    <form class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 px-3 md:px-8 py-3 md:py-4" enctype="multipart/form-data">
                        <textarea class="w-full resize-y min-h-[38px] md:min-h-[42px] max-h-[100px] border border-gray-300 dark:border-gray-600 rounded p-2 mb-2 text-xs md:text-sm focus:outline-blue-400 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100" placeholder="Написать сообщение..."></textarea>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="ml-auto text-xs text-gray-400 block">Max size = 20Mb, max count = 10</span>
                            <span class="p-1.5 rounded-[5px] bg-gray-50 dark:bg-gray-900">
                                <label class="cursor-pointer flex items-center gap-1">
                                <input type="file" class="hidden" multiple>
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15.172 7l-6.586 6.586a2 2 0 002.828 2.828L17 10.828M7 7l10 10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </label>
                            </span>
                            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition text-xs md:text-base">Отправить</button>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>
@endsection
