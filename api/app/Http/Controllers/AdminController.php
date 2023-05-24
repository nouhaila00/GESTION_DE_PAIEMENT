<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Traits\HttpResponses;
use App\Models\Administrateur;
use App\Http\Requests\UpdateToAdmin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function show($PPR)
    {   $auth=Auth::user();
        if($auth->type ==='Admin_Etabblissement' && $auth->administrateur->PPR !==$PPR )
        {
              return $this->error('','Acces non authorisé',403);
        }
        elseif ($auth->type ==='Directeur' && $auth->administrateur->PPR !==$PPR)
        {
            return $this->error('','Acces non authorisé',403);
       }
       else {
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
    }}

    public function UpdateByUniv(UpdateByUniv $request, $PPR)
    {
        $validatedData = $request->validated();
        if(!$validatedData) 
        {
            return $this->error('','informations invalides',401);
        }

        $admin = Administrateur::where('PPR',$PPR)->get();

        if(!$admin) 
        {return $this->error('','administrateur non trouvé',404);}
    else {
        $code = $validatedData['code'];
        $etab = Etablissement::where('code',$code)->first();
        $admin->id_etablissement = $etab->id_etablissement;
        $admin->nom = $validatedData['nom'];
        $admin->prenom = $validatedData['prenom'];
        $admin->date_naissance = $validatedData['date_naissance'];
        $admin->save();
     }

        $user= User::where('id',$admin->id_user);
        if(!$user) {return $this->error('','utilisateur non trouvé',404);}
        
        $user->type = $validatedData['type'];
        $user->email = $validatedData['email'];
        $user->password = $validatedData['password'];
        $user->save();
        
        return $this->success([
            'user'=>$user,
            'admininstarteur'=>$admin
        ],'modifications bien enregistrées',200);

    }

    public function update(UpdateToAdmin $request, $PPR)
    {   $auth=Auth::user();
        if($auth->administrateur->PPR !== $PPR)
        {
            return $this->error('','Accèc non authorisé',403);
        }
        $validatedData = $request->validated();
        if(!$validatedData) 
        {
            return $this->error('','informations invalides',401);
        }

        $admin = Administrateur::where('PPR',$PPR)->get();

        if(!$admin) 
        {return $this->error('','administrateur non trouvé',404);}
    else {
        
        $admin->nom = $validatedData['nom'];
        $admin->prenom = $validatedData['prenom'];
        $admin->date_naissance = $validatedData['date_naissance'];
        $admin->save();
     }

        $user= User::where('id',$admin->id_user);
        if(!$user) {return $this->error('','utilisateur non trouvé',404);}
        
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
