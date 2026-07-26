<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'producto',
        'stock_actual',
        'stock_minimo',
        'precio'
    ];


    public function getEstadoStockAttribute()
    {
        if ($this->stock_actual <= 0) {
            return 'agotado';
        } elseif ($this->stock_actual <= $this->stock_minimo) {
            return 'bajo';
        } else {
            return 'normal';
        }
    }


    public function getEstadoColorAttribute()
    {
        return match ($this->estado_stock) {
            'agotado' => 'bg-red-100 text-red-800',
            'bajo' => 'bg-yellow-100 text-yellow-800',
            'normal' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function scopeStockBajo($query)
    {
        return $query->where('stock_actual', '<=', 'stock_minimo');
    }

    public function scopeAgotados($query)
    {
        return $query->where('stock_actual', '<=', 0);
    }
}