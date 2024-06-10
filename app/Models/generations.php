<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class generations extends Model
{
    use HasFactory;
    protected $fillable = [
        'generation_head_id',
        'date_from',
        'date_to',
        'payee_id',
        'payee_name',
        'registered_address',
        'tin',
        'zip_code',
        'tax_type',
        'atc_id',
        'atc_code',
        'atc_remarks',
        'atc_percentage',
        'amount',
        'total',
        'include_sign',
        'reference_number',
        'accountant_id',
        'accountant_name',
        'accountant_position',
        'accountant_tin',
        'accountant_sign',
        'user_id',
        'cancelled',
    ];

    public function generation_amount()
    {
        return $this->belongsTo(GenerationAmount::class, 'generation_id');
    }

    public function generation_head()
    {
        return $this->belongsTo(GenerationHead::class, 'generation_head_id');
    }
}
