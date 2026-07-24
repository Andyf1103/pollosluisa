<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'ci',
        'nombre',
        'email',
        'telefono',
        'fecha_nacimiento'
    ];
}
