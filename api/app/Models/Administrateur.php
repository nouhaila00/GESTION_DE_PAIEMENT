<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;
    
protected $fillable = [
            'PPR',
            'nom',
            'prenom',
            'date_naissance',
            'id_etablissement',
            'id_user'        
        ];

        public function etablissement()
    {
        return $this->belongsTo(Etablissement::class,'id_etab');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id_user');
    }

}
