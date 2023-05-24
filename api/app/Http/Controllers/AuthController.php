<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Enseignant;
use App\Models\Administrateur;
use App\Models\Etablissement;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\LoginUser;
use App\Http\Requests\RegisterEns;
use App\Http\Requests\RegisterAdmin;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses,HasApiTokens;

    public function login(LoginUser $request)
    {
        $validatedData =$request->validated();
        if(!Auth::attempt($validatedData))
        {
            return $this->error('','information invalide',401);
        }

        $user= User::where('email',$validatedData['email'])->first();
        $token=$user->createToken('API Token ' )->plainTextToken;
         
        return $this->success([
            'user' => $user,
            'token' => $token,

        ]);
        
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json('Déconnexion réussie');
    }

    public function registerEnseignant(RegisterEns $request)
    {
        //validation des données
        $validatedData =$request->validated();

        if (!$validatedData) {
            return $this->error('','informations invalides',401);
        }
        //recupération de l'id_etablissement
        $userid = Auth::User()->id_user;
        $admin = Administrateur::where('id_user',$userid)->first();

        if(!$admin){
            return $this->error('','Etablissement non trouvée ',422);
        }

        $etbId = $admin->id_etablissement;

        //recupération de l'id_grade
        $designation = $validatedData['designation'];
        $grade = Grade::where('designation',$designation)->first();

        if (!$grade) {
            return $this->error('','Grade Invalide',422);
        }
        
        $gradeid = $grade->id;

        //creation du user
        
        $validatedData['password'] = Hash::make($validatedData['password']);
        
       
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'type' => $validatedData['type']
                ]);

         if (!$user) {
             return $this->error('','l\'inscription a échouée',422);
        }

        //insertion de l'enseignent

        $enseignant = Enseignant::create([
                        'PPR' => $validatedData['PPR'],
                        'nom' => $validatedData['nom'],
                        'prenom' => $validatedData['prenom'],
                        'date_naissance' => $validatedData['date_naissance'],
                        'id_etab' => $etbId,
                        'id_grade' => $gradeid,
                        'id_user' => $user->id
                                ]);
                                
    
        if (!$enseignant) {
            // Supprimer l'utilisateur précédemment créé en cas d'échec
            $user->delete();
            return $this->error('','l\'inscription a échouée',422);
        }
        //succes de l'inscription                       
        return $this->success([
           'user' => $user ,
           'enseignant' => $enseignant   
        ], 'Utilisateur inscrit avec succès');
    }



    public function registerAdmin(RegisterAdmin $request)
    {
        //validation des données
        $validatedData =$request->validated();
    
        if (!$validatedData) {
            return $this->error('','informations invalides',401);
        }
        $validatedData['password'] = Hash::make($validatedData['password']);

        //creation du user
        $user = User::create([
                        'email' => $validatedData['email'],
                        'password' => $validatedData['password'],
                        'type' => $validatedData['type']
                    ]);
                   
        if (!$user) {
            return $this->error('','l\'inscription a échouée',422);
        }
         //inscription President
         
        if($validatedData['type']==='President')
            return $this->success([
                'user' => $user , 
            ], 'Utilisateur inscrit avec succès');


        //insertion de l'administrateur
        $code = $validatedData['code'];
        $etab = Etablissement::where('code',$code)->first();
        if (!$etab) {
        
            // Gérer le cas où l'établissement n'est pas trouvé
            return $this->error('', 'Établissement non trouvé', 422);
        }
        $administrateur = Administrateur::create([
                            'PPR' => $validatedData['PPR'],
                            'nom' => $validatedData['nom'],
                            'prenom' => $validatedData['prenom'],
                            'date_naissance' => $validatedData['date_naissance'],
                            'id_etablissement' => $etab->id,
                            'id_user' => $user->id
                            ]);
    
        if (!$administrateur) {
            // Supprimer l'utilisateur précédemment créé en cas d'échec
            $user->delete();
            return $this->error('','l\'inscription a échouée',422);
        }
            //succes de l'inscription                     
            return $this->success([
                'user' => $user ,
                'administrateur' => $administrateur  
            ], 'Utilisateur inscrit avec succès');
    
    }

    
}
