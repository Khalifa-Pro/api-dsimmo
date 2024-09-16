<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'user_id',
        'appartement_id',
        'etat_validation',
        'mensualite',
        'paiement'
    ];
}
