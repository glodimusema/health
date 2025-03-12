<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
// use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Connexion\ConnexionController;

use App\Http\Controllers\SimpleExcelController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    function fetch_menu_roles($refRole)
    {
        $data = DB::table('tconf_crud_access')
        ->join('roles','roles.id','=','tconf_crud_access.refRole')        
        ->select("tconf_crud_access.id" ,"roles.nom",'insert','update','delete','load','tconf_crud_access.author')
        ->where('tconf_crud_access.refRole', $refRole)
        ->get();

        return $data;
    }
    $roless;
    if (auth()->user()) {
        # code...
        $id_role = auth()->user()->id_role;
        $roless = fetch_menu_roles($id_role);
       
    } else {
        # code...
         $roless = [];         
    }   


    return view('admin', ['roless'   => $roless]);
});

Route::get('/admin', function () {
    function fetch_menu_roles($refRole)
    {
        $data = DB::table('tconf_crud_access')
        ->join('roles','roles.id','=','tconf_crud_access.refRole')        
        ->select("tconf_crud_access.id" ,"roles.nom",'insert','update','delete','load','tconf_crud_access.author')
        ->where('tconf_crud_access.refRole', $refRole)
        ->get();

        return $data;
    }
    $roless;
    if (auth()->user()) {
        # code...
        $id_role = auth()->user()->id_role;
        $roless = fetch_menu_roles($id_role);
       
    } else {
        # code...
         $roless = [];
         
    } 
    return view('admin', ['roless'   => $roless]);
});

Route::get('/dash', [App\Http\Controllers\HomeController::class, 'dash'])->name('dash');

Route::resource('/contact', ContactController::class);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
    return view('frontend.connexion');
});

Route::get('/register', function () {
    return view('frontend.register');
});

Route::get('/forgot', function () {
    return view('frontend.forgot');
});

Route::get('resete', function () {
    return view('frontend.resete');
});

Route::group(['namespace'   =>  "Connexion"], function(){
    Route::post("checkLogin", [ConnexionController::class, 'checkLogin']);
    //  Route::post("register_count", 'ConnexionController@creationCompte');
    Route::get("logout", [ConnexionController::class, 'logout']);
});

/*
*
*======================
*importer et exporter 
*======================
*
*/


// Exporter un fichier Excel
Route::get("exportation", [SimpleExcelController::class, 'export'])->name('exportation');
Route::get("ShowdetailfacturationAbonneeExcel", [SimpleExcelController::class, 'ShowdetailfacturationAbonneeExcel']);
Route::get("ShowdetailfacturationPriveeExcel", [SimpleExcelController::class, 'ShowdetailfacturationPriveeExcel']); 

/*
*
*======================
*importer et exporter 
*======================
*
*/

Route::get('/{any}', function () {
             
    function fetch_menu_roles($refRole)
    {
        $data = DB::table('tconf_crud_access')
        ->join('roles','roles.id','=','tconf_crud_access.refRole')        
        ->select("tconf_crud_access.id" ,"roles.nom",'insert','update','delete','load','tconf_crud_access.author')
        ->where('tconf_crud_access.refRole', $refRole)
        ->get();

        return $data;
    }
    $roless;
    if (auth()->user()) {
        # code...
        $id_role = auth()->user()->id_role;
        $roless = fetch_menu_roles($id_role);
       
    } else {
        # code...
         $roless = [];
         
    } 

    return view('admin', ['roless'   => $roless]);
})->where('any', '.*');

