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
        $token=$user->createToken('API Token ' )->plainTextToken;
         
        return $this->success([
            'user' => $user,
            'token' => $token,

        ]);
        
    }

    public function logout(LogoutUser $requete)
{
    $requete->user()->currentAccessToken()->delete();
    return response()->json('Déconnexion réussie');
}
}
