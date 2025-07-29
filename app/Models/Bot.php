<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bot_token',
        'bot_name',
        'bot_username',
        'is_active',
        'owner_id', // ← добавить обязательно!
        'invite_code', // если есть
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operators()
    {
        return $this->belongsToMany(User::class, 'bot_user', 'bot_id', 'user_id');
    }

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'owner_id');
    }
}
