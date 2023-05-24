<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Administrateur;
use App\Models\Etablissement;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function show($PPR)
    {
        $administrateur = Administrateur::find($PPR);
        if(!$administrateur){
            return $this->error('','administrateur non trouvé',404);
        }
        $user = User::where('id',$administrateur->id_user);
        if(!$user){
            return $this->error('','utilisateur non trouvé',404);
        }
        return $this->success([
            'administrateur'=>$administrateur,
            'user'=>$user
        ],'administrateur trouvé',200);
    }

    public function update(Request $request, $PPR)
    {
        $validatedData = $request->validate();
        if(!$validatedData) 
        {
            return $this->error('','informations invalides',401);
        }

        $admin = Administrateur::where('PPR',$PPR)->get();

        if(!$admin) return $this->error('','administrateur non trouvé',404);
    
        $code = $validatedData['code'];
        $etab = Etablissement::where('code',$code)->first();
        $admin->id_etablissement = $etab->id_etablissement;
        $admin->nom = $validatedData['nom'];
        $admin->prenom = $validatedData['prenom'];
        $admin->date_naissance = $validatedData['date_naissance'];
        $admin->save();

        $user= User::where('id',$admin->id_user);
        if(!$user) return $this->error('','utilisateur non trouvé',404);
        
        if($user != Auth::User())
        {
            $user->type = $validatedData['type'];
        }

        $user->email = $validatedData['email'];
        $user->password = $validatedData['password'];
        $user->save();
        
        return $this->success([
            'user'=>$user,
            'admininstarteur'=>$admin
        ],'modifications bien enregistrées',200);

    }

    public function destroy($PPR)
    {
        $admin= Administrateur::where('PPR',$PPR);
        if($admin){
            $admin->delete();
            return $this->success('','administrateur supprimé',200);
        }
        return $this->error('','administrateur non trouvé',404);
    }
}
