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
            'code',
            'id_etablissement',
            'id_user'        
        ];

}
