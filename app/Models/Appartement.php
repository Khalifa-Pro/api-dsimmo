<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'prix',
        'image',
        'videos',
        'adresse',
        'disponibilite',
        'status',
        'superficie',
        'nombre_de_pieces',
        'niveau',
        'numero_appartement',
        'user_id',
    ];
}
