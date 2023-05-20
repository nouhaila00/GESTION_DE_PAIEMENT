<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnseignantController extends Controller
{    use HttpResponses,HasFactory;

    public function indexByEtab($etab_id)
    {    $etablissement=Etablissement::find($etab_id);
        if($etablissement){
        $ensg = Enseignant::where('id_etab',$etab_id)->with('Grade')->paginate(20);
        return  $this->success ($ensg, 'La liste des enseignant','');
        }
        else {
            return $this->error('','Etablissement non trouvée',422);
        }
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $ensg=Enseignant ::with('Grade')->find($id);
        if($ensg){
            $enseignantAvecGrade = $ensg;
             $enseignantAvecGrade['designation_grade'] = $ensg->Grade->designation;
            return $this->success($enseignantAvecGrade);

        }
         else{
            return $this->error('','Cet enseignant n\'existe pas ',422);
         }
    }

    public function update(Request $request,  $id)
{
            $enseignant= Enseignant ::with('Grade','User')->find($id);
            if($enseignant){
            $val=$request->validated();
            if($val){
                $enseignant->fill([

                       'PPR ' => $val['PPR'],
                       'nom'  => $val['nom' ],
                       'prenom'=> $val['prenom' ],
                       'date_naissance'=> $val['ate_naissance' ],]);
                 // Mettre à jour le grade associé
              $grade = Grade::find($val['id_grade']);
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
                 'password' =>$val['password'],
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

    public function destroy($id )
    {
        $ensg=Enseignant ::find($id);
        if($ensg){
            $ensg->delete();
           return $this->success ('', 'l\'Enseignant supprimé avec succès','');
        }
        else {
        return $this->error('', 'Enseignant non trouvé',422);}
    }
}
