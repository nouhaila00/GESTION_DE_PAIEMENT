<?php

namespace App\Models;

use App\Models\Intervention;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etablissement extends Model
{
    use HasFactory;
    public function intervention()
    {
        return $this->hasMany(Intervention::class, 'id', 'id_intervenant');
    }
}
