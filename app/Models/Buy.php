<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $table = 'buys';

    protected $fillable = [
        'order_id',
        'customer_id',
        'fecha',
        'estado',
    ];
}
