<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class programSlot extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'meeting_key',
        'program_key',
        'begins',
        'ends'
    ];
}
