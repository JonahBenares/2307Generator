<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountUpdateLogs extends Model
{
    use HasFactory;
    protected $table = 'amount_update_logs';
    protected $fillable = [
        'date_updated',
        'generation_head_id',
        'generation_id',
        'quarter_month',
        'old_amount',
        'new_amount',
        'old_tax_base_amount',
        'new_tax_base_amount',
        'user_id'
    ];
}
