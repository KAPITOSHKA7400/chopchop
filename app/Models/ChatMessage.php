<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chat_message';
    public $timestamps = false;

    protected $fillable = [
        'bot_token',
        'chat_id',
        'telegram_user_id',
        'username',
        'text',
        'created_at',
    ];
}
