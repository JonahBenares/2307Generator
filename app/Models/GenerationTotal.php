<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerationTotal extends Model
{
    use HasFactory;
    protected $table = 'generation_total';
    protected $fillable = [
        'generation_id',
        'generation_head_id',
        'row',
        'sub_total',
        'ewt_total',
        'user_id'
    ];
}
