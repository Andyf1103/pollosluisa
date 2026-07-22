<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'pedido_id',
        'inventario_id',
        'cantidad',
        'subtotal'
    ];

    public function pedido()
    {
        return $this->belongsTo(Order::class, 'pedido_id');
    }

    public function inventario()
    {
        return $this->belongsTo(Inventory::class, 'inventario_id');
    }
}