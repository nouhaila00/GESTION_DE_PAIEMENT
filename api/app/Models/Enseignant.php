<?php

namespace App\Models;

use App\Models\Intervention;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enseignant extends Model
{
    use HasFactory;
    protected $fillable = [
        'ppr',
        'nom',
        'prenom',
        'date_naissance',
        'id_etablissement',
        'id_grade',
        'id_user'

    ];
    public function intervention()
    {
        return $this->hasMany(Intervention::class);
    }
}
