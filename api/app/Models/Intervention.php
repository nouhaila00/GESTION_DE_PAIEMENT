<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;
    protected $table = 'interventions';

    protected $fillable = [
             'id_intervenant',
             'id_Etab',
             'intitule_intervention',
             'Annee_univ',
             'Semestre',
             'Date_debut',
             'Date_fin',
             'Nbr_heures',
             'visa_etb',
             'visa_uae',
    ];
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'id_etab');
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'id_intervenant');
    }
}
