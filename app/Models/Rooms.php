<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;
    protected $table = "rooms";
    protected $fillable = [
        "my_id",
        "other_id",
        "room_name",
        "room_date"
    ];
}
