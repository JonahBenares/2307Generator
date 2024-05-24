<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accountant extends Model
{
    use HasFactory;
    protected $fillable = [
        'accountant_name',
        'position',
        'tin',
        'signature',
        'active'
    ];
}
