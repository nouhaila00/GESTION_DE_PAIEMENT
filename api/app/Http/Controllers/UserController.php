<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function show($email)
    {
        $user= User::find($email);
        if(!$user){
            return $this->error('','utilisateur non trouvé',404);
        }
        return $this->success($user,'utilisateur trouvé',200);
    }

    public function update(Request $request, $email)
    {
        $validatedData = $request->validate();
        if(!$validatedData) 
        {
            return $this->error('','informations invalides',401);
        }

        $user= User::where('email',$email);
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
        ],'modifications bien enregistrées',200);

    }

    public function destroy($email)
    {
        $user = User::where('email',$email);
        if($user){
            $user->delete();
            return $this->success('','utilisateur supprimé',200);
        }
        return $this->error('','utilisateur non trouvé',404);
    }
}
