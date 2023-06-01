<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockUser extends Model
{
    use HasFactory;
    protected $table = "block_user";
    protected $fillable = [
        'repoter_ip',
        'block_ip'
    ];
}
