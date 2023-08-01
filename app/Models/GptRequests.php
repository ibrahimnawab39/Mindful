<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GptRequests extends Model
{
    use HasFactory;
    protected $table = "gpt_requests";
    protected $fillable = [
        "user_id",
        "prompt",
    ];
}
