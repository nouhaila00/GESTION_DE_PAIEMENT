<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Traits\HttpResponses;
use Illuminate\Http\Response;
use App\Http\Requests\UpdateEns;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnseignantController extends Controller
{    use HttpResponses,HasFactory;

    public function indexByEtab($etab_code)
    {   $etablissement = Etablissement::Where('code', $etab_code)->first();
        if ($etablissement) {
            $etab_id = $etablissement->id;
            $user= Auth::User();
            if($user->type == 'Admin_Université')
            {$ensg = Enseignant::where('id', $etab_id)->with('Grade')->paginate(20);}
            elseif ($user->type == 'Admin_Etablissement' && $user->administrateur->etablissement->code == $etab_code)
            {
                $ensg = Enseignant::whereHas('etablissement', function ($query) use ($etab_code) { $query->where('code', $etab_code);})->with('Grade')->get();

            }
            else {
                return $this->error('', 'Accès non autorisé', 403);
            }
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
        $ensg=  Enseignant ::with('Grade','User')->where('ppr', $ppr)->first();
        if($ensg){
            $enseignantAvecGrade = $ensg;
             $enseignantAvecGrade['designation_grade'] = $ensg->Grade->designation;
             $enseignantAvecGrade['email']=$enseignantAvecGrade->User->email;
            return $this->success($enseignantAvecGrade);

        }
         else{
            return $this->error('','Cet enseignant n\'existe pas ',422);
         }
    }

    public function update(UpdateEns $request,  $ppr)
{
            $enseignant= Enseignant ::with('Grade','User')->where('ppr', $ppr)->first();

            if($enseignant){
            $val=$request->validated();
            if($val){
                $enseignant->fill([
                       'nom'  => $val['nom' ],
                       'prenom'=> $val['prenom' ],
                       'date_naissance'=> $val['date_naissance' ],]);
                 // Mettre à jour le grade associé
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
                  try {
                    $this->authorize('update-enseignant-grade', $enseignant);
                    $grade = Grade::firstWhere('designation', $val['designation']);
                    if (!$grade) {
                        return $this->error('', 'Grade non trouvé', 422);
                    }
                    $enseignant->grade()->associate($grade);
                } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
                }

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
        $ensg= Enseignant ::where('ppr', $ppr)->first();
        if($ensg){
            $ensg->delete();
           return $this->success ('', 'l\'Enseignant supprimé avec succès','');
        }
        else {
        return $this->error('', 'Enseignant non trouvé',422);}
    }
}
