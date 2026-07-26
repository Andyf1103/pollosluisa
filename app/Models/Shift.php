<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    protected $fillable = [
        'hora_entrada',
        'hora_salida',
        'dias_descanso'
    ];

    protected $casts = [
        'dias_descanso' => 'array',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'shift_id');
    }
}