<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBlockWords extends Model
{
    use HasFactory;
    protected $table = "chat_block_words";
    protected $fillable = [
        'block_words'
    ];
}
