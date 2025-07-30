<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TgChatUser extends Model
{
    protected $table = 'tg_chat_users';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'username',
        'first_name',
        'last_name',
        'avatar_url',
        'created_at',
        'updated_at',
    ];
}
