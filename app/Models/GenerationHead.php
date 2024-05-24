<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerationHead extends Model
{
    use HasFactory;
    protected $table = 'generation_head';
    protected $fillable = [
        'date_encoded',
        'group_id',
        'user_id',
        'status'
    ];
}
