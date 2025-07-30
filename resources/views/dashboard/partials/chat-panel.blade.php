{{-- resources/views/dashboard/partials/chat-panel.blade.php --}}

<h1 class="text-2xl font-bold mb-4">Чаты</h1>
<div class="flex flex-col md:flex-row bg-gray-50 dark:bg-gray-800 rounded-xl shadow overflow-hidden mb-4">
    <div id="sidebar-chats">
        @include('dashboard.partials.chat-sidebar')
    </div>
    <div id="chat-messages">
        @include('dashboard.partials.chat-messages')
    </div>
</div>

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadSidebarChats() {
            $.get('{{ route("dashboard.chats.list", request()->all()) }}', function(data) {
                $('#sidebar-chats').html(data);
            });
        }
        function loadChatMessages() {
            $.get('{{ route("dashboard.chats.messages", request()->all()) }}', function(data) {
                $('#chat-messages').html(data);
            });
        }
        setInterval(function(){
            loadSidebarChats();
            loadChatMessages();
        }, 3000);
    </script>
@endsection
