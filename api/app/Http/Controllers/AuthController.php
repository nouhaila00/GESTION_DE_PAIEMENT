<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\LoginUser;
use App\Http\Requests\LogoutUser;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

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
        $token=$user->createToken('API Token of ' . $user->name)->plainTextToken;
         switch($user->type)
         {
            case 'Directeur': $view='directeur_dashboard';
            break;
            case 'President' : $view='president_dashboard';
            break;
            case 'Enseignant' : $view='enseignat_dashboard';
            break;
            case 'Admin_Etablissement' : $view='admin_etab_dashboard';
            break;
            case 'Admin_Université' : $view ='admin_univ_dashboard';
            break;
            
         }
        return $this->success([
            'user' => $user,
            'token' => $token,
            'view' => $view
        ]);
        
    }

    public function logout(LogoutUser $requete)
{
    $requete->user()->currentAccessToken()->delete();
    return response()->json('Déconnexion réussie');
}
}
