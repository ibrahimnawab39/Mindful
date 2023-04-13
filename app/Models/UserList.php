<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    use HasFactory;
    protected $table = "user_list";
    protected $fillable = [
        "username",
        "religion",
        "status",
        "connect_with",
        "interest",
        "ip_address"
    ];
}
