<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerationAmount extends Model
{
    use HasFactory;
    protected $table = 'generation_amount';
    protected $fillable = [
        'generation_head_id',
        'generation_id',
        'quarter_month',
        'amount',
        'tax_base_amount',
        'user_id'
    ];

    public function generation()
    {
        return $this->belongsTo(generations::class);
    }

    public function generation_head()
    {
        return $this->belongsTo(GenerationHead::class);
    }
}
