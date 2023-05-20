<?php

namespace App\Models;

use App\Models\User;
use App\Models\Grade;
use App\Models\Etablissement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enseignant extends Model
{
    use HasFactory;
    protected $table = 'enseignants';

    protected $fillable = [

        'PPR',
        'nom' ,
        'prenom',
        'date_naissance',
        'id_etab',
        'id_grade',
        'id_user',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class,'id_etab');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class,'id_grade');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id_user');
    }


}
