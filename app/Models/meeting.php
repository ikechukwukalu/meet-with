<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class meeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'name',
        'start_date',
        'end_date'
    ];
}
