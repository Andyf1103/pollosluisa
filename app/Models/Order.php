<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'table_id',
        'customer_id',
        'employee_id',
        'estado',
        'total',
        'fecha_pedido',
        'fecha'
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime',
        'fecha' => 'date',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'pedido_id');
    }
}