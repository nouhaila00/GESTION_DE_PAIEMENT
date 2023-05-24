<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function show($email)
    {   $auth=Auth::user();
        if($auth->type === 'President' && $auth->email !== $email)
        {
            return $this->error('','Accès non authorisé',403);
        }
        else {
        $user= User::find($email);
        if(!$user){
            return $this->error('','utilisateur non trouvé',404);
        }
        return $this->success($user,'utilisateur trouvé',200);
    }}

    public function update(UpdateUser $request, $email)
    {   
        $validatedData = $request->validated();
        if(!$validatedData) 
        {
            return $this->error('','informations invalides',401);
        }

        $user= User::where('email',$email);
        if(!$user) return $this->error('','utilisateur non trouvé',404);

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
