<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'pedido_id',
        'fecha',
        'total'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}