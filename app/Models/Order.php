<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_EN_PREPARACION = 'en_preparacion';
    const ESTADO_LISTO = 'listo';
    const ESTADO_ENTREGADO = 'entregado';
    const ESTADO_CANCELADO = 'cancelado';

    const ESTADOS = [
        self::ESTADO_PENDIENTE => 'Pendiente',
        self::ESTADO_EN_PREPARACION => 'En Preparación',
        self::ESTADO_LISTO => 'Listo',
        self::ESTADO_ENTREGADO => 'Entregado',
        self::ESTADO_CANCELADO => 'Cancelado',
    ];

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
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function sale()
    {
        return $this->hasOne(Sale::class, 'order_id');
    }

    public function getEstadoNombreAttribute()
    {
        $estados = [
            'pendiente' => 'Pendiente',
            'en_preparacion' => 'En Preparación',
            'listo' => 'Listo',
            'entregado' => 'Entregado',
            'cancelado' => 'Cancelado'
        ];
        return $estados[$this->estado] ?? $this->estado;
    }

    public function getEstadoColorAttribute()
    {
        $colores = [
            'pendiente' => 'bg-yellow-100 text-yellow-800',
            'en_preparacion' => 'bg-blue-100 text-blue-800',
            'listo' => 'bg-green-100 text-green-800',
            'entregado' => 'bg-purple-100 text-purple-800',
            'cancelado' => 'bg-red-100 text-red-800'
        ];
        return $colores[$this->estado] ?? 'bg-gray-100 text-gray-800';
    }

    public function getTotalOrdenAttribute()
    {
        return $this->orderDetails->sum('subtotal');
    }
}