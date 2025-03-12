<?php

namespace App\Http\Controllers\Connexion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\GlobalMethod;

use Auth;
use DB;

class ConnexionController extends Controller
{
    //
    use GlobalMethod;

    function checkLogin(Request $request)
    {
        $user_data = array(
             'email'    => $request->email,
             'password' => $request->password,
             'active'   => 1
        );

         return Auth::attempt($user_data) ?
         response()->json(['wrong' =>false])
         :
         response()->json(['wrong' =>true]);

         $id_role = auth()->user()->id_role;
         $rules = $this->fetch_menu_roles($id_role);

             
    }

    public function fetch_menu_roles($refRole)
    {
        $data = DB::table('tconf_crud_access')
        ->join('roles','roles.id','=','tconf_crud_access.refRole')        
        ->select("tconf_crud_access.id" ,"roles.nom",'insert','update','delete','load','tconf_crud_access.author')
        ->where('tconf_crud_access.refRole', $refRole)
        ->get();

        return $data;
    }


    function logout()
    {
         Auth::logout();
         return redirect('/login');
    }
}
