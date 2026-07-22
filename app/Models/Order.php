<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'mesa_id',
        'cliente_id',
        'empleado_id',
        'estado',
        'total',
        'fecha_pedido'
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime',
    ];

    public function mesa()
    {
        return $this->belongsTo(Table::class, 'mesa_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Customer::class, 'cliente_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Employee::class, 'empleado_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'pedido_id');
    }
}