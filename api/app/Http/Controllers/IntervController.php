<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Enseignant;
use App\Models\Intervention;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Traits\HttpResponses;
use App\Http\Requests\ReqInterv;
use Illuminate\Support\Facades\Auth;

class IntervController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function indexByEnsg($ppr)
     { $ensg = Enseignant::where('ppr', $ppr)->first();
         $user = Auth::user();

         if ($user->type === 'Directeur' && $user->administrateur->id_etab !== $ensg->id_etab) {
             return $this->error('', 'Accès non autorisé', 403);
             }
             else {
             if ($user->type === 'Admin_Université')
             {
                 // L'utilisateur est un Admin_Universite, toutes les interventions sont autorisées
                 $interventions = Intervention::where('id_intervenant',$ensg->id )->get();
             }
             elseif ($user->type === 'Admin_Etablissement')
              {
                $interventions = Intervention::where('id_intervenant', $ensg->id)->where('id_etab', $user->administrateur->id_etab)->get();
              }
             if ($interventions->isNotEmpty()) {
                 return $this->success($interventions, 'Les interventions concernées par cet enseignant', 200);
             } else {
                 return $this->error('', 'Aucune intervention correspondante', 422);
             }
         }
     }

public function ValidEtab(Intervention $intervention){
        $ensg = Enseignant::find($intervention->id_intervenant);
        $user = Auth::user();
        if ($user->type === 'Directeur'&& $user->administrateur->id_etab == $ensg->id_etab){
            $intervention->visa_etb=1;
            return $this->success($intervention, 'L\'intervention validée', 200);
        } else {
            return $this->error('', 'Accès non autorisé', 403);
        }
     }

public function AnnEtab(Intervention $intervention){
        $ensg = Enseignant::find($intervention->id_intervenant);
        $user = Auth::user();
        if ($user->type === 'Directeur'&& $user->administrateur->id_etab == $ensg->id_etab){
            $intervention->visa_etb= 0;
            return $this->success($intervention, 'L\'intervention validée', 200);
        } else {
            return $this->error('', 'Accès non autorisé', 403);
        }}



public function ValidUae(Intervention $intervention){
        $user = Auth::user();
        if ($user->type =='President' )
        { if($intervention->visa_etb==1) {
            $intervention->visa_uae=1;
                return $this->success($intervention, 'L\'intervention validée', 200);
            }
            else{
                return $this->error('','cette intervention n\'est pas validée par l\'etablissement',);
            }
        }
     else {
        return $this->error('', 'Accès non autorisé', 403);
    }
}
public function AnnUae(Intervention $intervention){
        $user = Auth::user();
        if ($user->type =='President'){
            $intervention->visa_uae=0;
                return $this->success($intervention, 'L\'intervention annulée', 200);
            }
        else {
            return $this->error('', 'Accès non autorisé', 403);
        }

}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReqInterv $request)

    {   $validatedData =$request->validated();
        $etab=Etablissement::where('code',$validatedData['code_etab'] )->first();
        $ensg=Enseignant::where('ppr',$validatedData['ppr'] )->first();
        if($etab){
            if($ensg){
                $intervention=Intervention:: create ([
                    'id_intervenant'=>$ensg->id,
                    'id_Etab'=>$etab->id,
                    'intitule_intervention'=>$validatedData['intitule_intervention'],
                    'Annee_univ'=>$validatedData['Annee_univ'],
                    'Semestre'=>$validatedData['Semestre'],
                    'Date_debut'=>$validatedData['Date_debut'],
                    'Date_fin'=>$validatedData['Date_fin'],
                    'Nbr_heures'=>$validatedData['Nbr_heures'],
                ]);
                return $this->success($intervention,'Intervention ajoutée',200);
            }
            else{
                return $this->error('','Enseignant non trouvée ',422);
                 }}
        else {
            return $this->error('','Etablissement non trouvée ',422);

        }
    }


    public function update(Request $request, Intervention $intervention)
    {     $validatedData =$request->validated();

        $intervention->fill([
            'intitule_intervention'=>$validatedData[ 'intitule_intervention'],
             'Annee_univ'=>$validatedData[ 'Annee_univ'],
             'Semestre'=>$validatedData['Semestre'],
             'Date_debut'=>$validatedData['Date_debut'],
             'Date_fin'=>$validatedData['Date_fin'],
             'Nbr_heures'=>$validatedData['Nbr_heures'],
        ])->save();

            return $this->success($intervention,'Intervention modifiée',200);


    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Intervention $intervention)
    {
        $intervention->delete();
    }
}
