<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnseignantController extends Controller
{    use HttpResponses,HasFactory;

    public function indexByEtab($etab_code)
    {   $etablissement = Etablissement::firstWhere('etab_code', $etab_code);
        if ($etablissement) {
            $etab_id = $etablissement->value('id_etablissement');
            $ensg = Enseignant::where('id_etab', $etab_id)->with('Grade')->paginate(20);
            return $this->success($ensg, 'La liste des enseignants', '');
        } else {
            return $this->error('', 'Etablissement non trouvé', 422);
        }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function show($ppr)
    {
        $ensg=  Enseignant ::with('Grade')->where('PPR', $ppr)->first();
        if($ensg){
            $enseignantAvecGrade = $ensg;
             $enseignantAvecGrade['designation_grade'] = $ensg->Grade->designation;
            return $this->success($enseignantAvecGrade);

        }
         else{
            return $this->error('','Cet enseignant n\'existe pas ',422);
         }
    }

    public function update(Request $request,  $ppr)
{
            $enseignant= Enseignant ::with('Grade','User')->where('PPR', $ppr)->first();

            if($enseignant){
            $val=$request->validated();
            if($val){
                $enseignant->fill([
                       'nom'  => $val['nom' ],
                       'prenom'=> $val['prenom' ],
                       'date_naissance'=> $val['date_naissance' ],]);
                 // Mettre à jour le grade associé
                 $grade = Grade::firstWhere('designation', $val['designation']);
                if (!$grade) {
              return $this->error('', 'Grade non trouvé', 422);
            }
             $enseignant->grade()->associate($grade);
              // Mettre à jour l'utilisateur associé
               $user = $enseignant->user;
               if (!$user) {
              return $this->error('', 'Utilisateur non trouvé', 422);
                  }

                $user->fill([
                 'email' => $val['email'],
                 'password' =>Hash::make($val['password']),
                      ]);
                  $user->save();
             $enseignant->save();

                return   $this->success ($enseignant, 'l\'enseignant est bien modifiié','');
                 }
                 else{
                     return $this->error('','Cet enseignant n\'existe pas ',422);
                 }}
            else {
                return $this->error('','information invalide',401);
            }
            }

    public function destroy($ppr )
    {
        $ensg= Enseignant ::where('PPR', $ppr)->first();
        if($ensg){
            $ensg->delete();
           return $this->success ('', 'l\'Enseignant supprimé avec succès','');
        }
        else {
        return $this->error('', 'Enseignant non trouvé',422);}
    }
}
