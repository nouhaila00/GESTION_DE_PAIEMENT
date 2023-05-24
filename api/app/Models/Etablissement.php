<?php

namespace App\Models;

use App\Models\Enseignant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etablissement extends Model
{
    use HasFactory;
    protected $table = 'etablissements';

    public function enseignant()
    {
        return $this->hasMany(Enseignant::class);
    }

    protected $fillable = [

        'code',
        'nom',
        'telephone',
        'faxe',
        'ville',
        'nbr_enseignant',
    ];
}
