<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'ci',
        'nombre',
        'email',
        'rol',          
        'shift_id'
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function getRolNombreAttribute()
    {
        $roles = [
            'admin' => 'Administrador',
            'cocinero' => 'Cocinero',
            'mesero' => 'Mesero'
        ];
        return $roles[$this->rol] ?? $this->rol;
    }

    public function scopeRol($query, $rol)
    {
        return $query->where('rol', $rol);
    }
}