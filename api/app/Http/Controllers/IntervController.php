<?php

namespace App\Http\Controllers;
use App\Traits\HttpResponses;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\Intervention;
use Illuminate\Http\Request;

class IntervController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


        public function index($idEnsg)
        {
            $interventions = Intervention::where('id_intervenant', $idEnsg)->get();
            if($interventions){
                return $this->success($interventions,'Les interventions concernée cet enseignant',200);
            }
            else {
                return $this->error('','Aucune intervention correspondante  ',422);
            }

        }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {   $validatedData =$request->validated();
        $etab=Etablissement::find($validatedData['id_etab'] );
        $ensg=Enseignant::find($validatedData['id_intervenant'] );
        if($etab){
            if($ensg){
                $intervention=Intervention:: create ([
                    'id_intervenant'=>$validatedData['id_intervenant'],
                    'id_Etab'=>$validatedData['id_etab'],
                    'intitule_intervention'=>$validatedData['intitule_intervention'],
                    'Annee_univ'=>$validatedData['Annee_univ'],
                    'Semestre'=>$validatedData['Semestre'],
                    'Date_debut'=>$validatedData['Date_debut'],
                    'Date_fin'=>$validatedData['Date_fin'],
                    'Nbr_heures'=>$validatedData['Nbr_heures'],
                ]);
                return $this->success($ensg,'Intervention ajoutée',200);
            }
            else{
                return $this->error('','Enseignant non trouvée ',422);
                 }}
        else {
            return $this->error('','Etablissement non trouvée ',422);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function show(Intervention $intervention)
    {



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Intervention  $intervention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Intervention $intervention)
    {   $validatedData =$request->validated();
        $etab=Etablissement::find($validatedData['id_etab'] );
        $ensg=Enseignant::find($validatedData['id_intervenant'] );
        if($etab){
            if($ensg){
        $intervention->fill($validatedData)->save();
        if ($intervention->wasChanged()) {
            return $this->success($intervention,'Intervention modifiée',200);
        } else {
            return $this->success($intervention,'Rien modifiée',200);
        }}
        else{
            return $this->error('','Enseignant non trouvée ',422);
             }}
    else {
        return $this->error('','Etablissement non trouvée ',422);

    }
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
