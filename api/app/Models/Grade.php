<?php

namespace App\Models;

use App\Models\Enseignant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{

    use HasFactory;
    protected $table = 'grades';
    public const DESIGNATION=[
        'PA',
        'PH',
        'PES'
    ];
    public function enseignant()
    {
        return $this->hasMany(Enseignant::class);
    }
    protected $fillable = [

        'id_grade'
    ];
}
