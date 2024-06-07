<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payees extends Model
{
    use HasFactory;
    protected $fillable = [
        'payee_name',
        'registered_address',
        'tin',
        'zip_code',
        'tax_type',
    ];
}
