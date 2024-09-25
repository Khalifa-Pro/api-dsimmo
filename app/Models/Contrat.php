<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_contrat',
        'date_debut',
        'date_fin',
        'type',
        'montant',
        'estValide',        // Ajouté
        'appartement_id',   // Ajouté
        'user_id',          // Ajouté
    ];

}
