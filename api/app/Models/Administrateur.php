<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;
    protected $fillable = [

        'PPR',
        'nom' ,
        'prenom',
        'date_naissance',
        'id_etab',
        'id_user',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class,'id_etab');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }
}
