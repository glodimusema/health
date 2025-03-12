<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{Entreprise,Photo_entreprise,VideoEntreprise};
use App\Traits\{GlobalMethod,Slug};
use DB;

use Illuminate\Support\Facades\Auth;
class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;
    public function index(Request $request)
    {


        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at");            
            $data->where([
                ['name', 'like', '%'.$query.'%']
            ])            
            ->orderBy("id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at")
            ->orderBy("entreprise.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
            
    }

    function getEntrepriseByCeo($ceo)
    {
        $data = DB::table('entreprise')
        ->join('users' , 'users.id','=','entreprise.ceo')
        ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
        ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
        ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
        "users.name","users.email as email_user","users.telephone","users.avatar",
        "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
        "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
        "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
        "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
        "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
        "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
        "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
        "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
        "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
        "entreprise.created_at","entreprise.updated_at")
        ->where('ceo', $ceo)->get();

        
        return response()->json(['data'  =>  $data]);
    }

    public function listEntrepriseFiltre(Request $request)
    {


        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at");
            $data->where([
                ['name', 'like', '%'.$query.'%'],
                ['statut', 0]
            ])            
            ->orderBy("entreprise.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at")
            ->where('statut', 0)           
            ->orderBy("entreprise.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }        
 
    }

    public function fetchEntrepriseCeo($ceo, Request $request)
    {


        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at");
            $data->where([
                ['name', 'like', '%'.$query.'%'],
                ['ceo', $ceo],
                ['statut', 0]
            ])            
            ->orderBy("entreprise.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at")
            ->where([
                ['ceo', $ceo],
                ['statut', 0]
            ])          
            ->orderBy("entreprise.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }

    function fetch_entreprise_deleted(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at");
            $data->where([
                ['name', 'like', '%'.$query.'%'],
                ['statut', 1]
            ])            
            ->orderBy("entreprise.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at")
            ->where('statut', 1)           
            ->orderBy("entreprise.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
        
    }

    function fetch_entreprise_2()
    {
        $data = Entreprise::where('statut', 0)->get();
        return response()->json(['data'  =>  $data]);
    }

    function fetch_myentreprise($ceo)
    {
        $data = Entreprise::where([
            ['ceo', $ceo],
            ['statut', 0],
        ])->get();
        return response()->json(['data'  =>  $data]);
    }

    //debit script
     function getMenuFiltrage()
    {
        $list = [];

         array_push($list, array(
            'listeProvince'             =>    $this->getDataFitrage("entreprise", "idProvince"),
            'listeSecteur'              =>    $this->getDataFitrage("entreprise", "idSecteur"),
            'listeFormeJuridique'       =>    $this->getDataFitrage("entreprise", "idForme"),
      
        ));

        return response()->json(['data' => $list]);
        
    }

    //filtrage des donnees
    function getEntreprisePprovince($idProvince, Request $request){
        //
        $data = DB::table('entreprise')
        ->join('users' , 'users.id','=','entreprise.ceo')
        ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
        ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
        ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
        "users.name","users.email as email_user","users.telephone","users.avatar",
        "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
        "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
        "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
        "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
        "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
        "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
        "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
        "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
        "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
        "entreprise.created_at","entreprise.updated_at")
        ->where('idProvince', $idProvince)
        ->orderBy("entreprise.id", "desc")->paginate(50);

        return response()->json([
            'data'  => $data,
        ]);

        
    }

    function getentrepriseecteur($idSecteur, Request $request){
        //
        $data = DB::table('entreprise')
        ->join('users' , 'users.id','=','entreprise.ceo')
        ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
        ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
        ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
        "users.name","users.email as email_user","users.telephone","users.avatar",
        "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
        "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
        "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
        "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
        "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
        "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
        "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
        "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
        "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
        "entreprise.created_at","entreprise.updated_at")
        ->where('idSecteur', $idSecteur)
        ->orderBy("entreprise.id", "desc")->paginate(50);

        return response()->json([
            'data'  => $data,
        ]);
    }

    function getEntrepriseForme($idForme, Request $request){
        //
        $data = DB::table('entreprise')
        ->join('users' , 'users.id','=','entreprise.ceo')
        ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
        ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
        ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
        "users.name","users.email as email_user","users.telephone","users.avatar",
        "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
        "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
        "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
        "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
        "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
        "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
        "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
        "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
        "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
        "entreprise.created_at","entreprise.updated_at")
        ->where('idForme', $idForme)
        ->orderBy("entreprise.id", "desc")->paginate(50);

        return response()->json([
            'data'  => $data,
        ]);       
    }
    //fin filtrage des donnees






    function getDataFitrage($table, $column)
    {
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table('entreprise')
        ->join('users' , 'users.id','=','entreprise.ceo')
        ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
        ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
        ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
        "users.name","users.email as email_user","users.telephone","users.avatar",
        "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
        "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
        "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
        "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
        "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
        "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
        "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
        "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
        "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
        "entreprise.created_at","entreprise.updated_at")
        ->groupBy($table.'.'.$column)
        ->get();
        $list = [];
        foreach ($data as $row) {
            array_push($list, array(
                'idProvince'    =>      $row->idProvince,
                'nomProvince'   =>      $row->nomProvince,
                'ceo'           =>      $row->ceo,
                'idPays'        =>      $row->idPays,
                'nomPays'       =>      $row->nomPays,
                'idSecteur'     =>      $row->idSecteur,
                'nomSecteur'    =>      $row->nomSecteur,
                'idForme'       =>      $row->idForme,
                'nomForme'      =>      $row->nomForme,
                
                'nbrEntreprise' =>      $this->showCountTableWhere('entreprise',$column, $row->$column),

            ));

        }
        return $list;

    }


    //fin script

     /*
    * fin filtrage des requetes pour les entreprise
    * ==========================================
    *
    */

    public function showCeoEntreprise(Request $request)
    {

        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at");
            $data->where([
                ['name', 'like', '%'.$query.'%'],                
                ['statut', 0]
            ])            
            ->orderBy("entreprise.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('entreprise') 
            ->join('users' , 'users.id','=','entreprise.ceo')
            ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
            ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
            ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
            "users.name","users.email as email_user","users.telephone","users.avatar",
            "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
            "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
            "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
            "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
            "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
            "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
            "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
            "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
            "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
            "entreprise.created_at","entreprise.updated_at")
            ->where([                
                ['statut', 0]
            ])          
            ->orderBy("entreprise.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
        
    }



    



    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $stringToSlug=substr($formData->nom, 0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            $request->image->move(public_path('/fichier'), $imageName);

            

            Entreprise::create([
                'idProvince'    =>  $formData->idProvince,
                'ceo'           =>  $formData->ceo,
                'nom'           =>  $formData->nom,
                'email'         =>  $formData->email,
                'adresse'       =>  $formData->adresse,
                'tel1'          =>  $formData->tel1,
                'tel2'          =>  $formData->tel2,
                'siteweb'       =>  $formData->siteweb,
                'facebook'      =>  $formData->facebook,
                'twitter'       =>  $formData->twitter,
                'linkedin'      =>  $formData->linkedin,

                'idnational'    =>  $formData->idnational,
                'rccm'          =>  $formData->rccm,
                'numImpot'      =>  $formData->numImpot,
                'id_user_insert'        =>  $formData->connected,
                'busnessName'           =>  $formData->busnessName,
                'codeBusness'           =>  $formData->codeBusness,
                'idSecteur'             =>  $formData->idSecteur,
                'contactNumCode'        =>  $formData->contactNumCode,
                'anneeFondation'        =>  $formData->anneeFondation,
                'numCaisseSocial'       =>  $formData->numCaisseSocial,
                'numInpp'               =>  $formData->numInpp,
                'idForme'               =>  $formData->idForme,
                'numPersonneJuridique'  =>  $formData->numPersonneJuridique,
                
                'slug'          =>  $slug,
                'logo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            $stringToSlug=substr($formData->nom, 0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
            Entreprise::create([
                'idProvince'    =>  $formData->idProvince,
                'ceo'           =>  $formData->ceo,
                'nom'           =>  $formData->nom,
                'email'         =>  $formData->email,
                'adresse'       =>  $formData->adresse,
                'tel1'          =>  $formData->tel1,
                'tel2'          =>  $formData->tel2,
                'siteweb'       =>  $formData->siteweb,
                'facebook'      =>  $formData->facebook,
                'twitter'       =>  $formData->twitter,
                'linkedin'      =>  $formData->linkedin,

                'idnational'    =>  $formData->idnational,
                'rccm'          =>  $formData->rccm,
                'numImpot'      =>  $formData->numImpot,
                'id_user_insert'        =>  $formData->connected,
                'busnessName'           =>  $formData->busnessName,
                'codeBusness'           =>  $formData->codeBusness,
                'idSecteur'             =>  $formData->idSecteur,
                'contactNumCode'        =>  $formData->contactNumCode,
                'anneeFondation'        =>  $formData->anneeFondation,
                'numCaisseSocial'       =>  $formData->numCaisseSocial,
                'numInpp'               =>  $formData->numInpp,
                'idForme'               =>  $formData->idForme,
                'numPersonneJuridique'  =>  $formData->numPersonneJuridique,
                
                'slug'          =>  $slug,
                'logo'         =>  "avatar.png"
            ]);
            return $this->msgJson('Information ajoutée avec succès');

        }

    }

    function updateData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);

            $stringToSlug=substr($formData->nom, 0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
           
            Entreprise::where('id',$formData->id)->update([
                'idProvince'    =>  $formData->idProvince,
                'ceo'           =>  $formData->ceo,
                'nom'           =>  $formData->nom,
                'email'         =>  $formData->email,
                'adresse'       =>  $formData->adresse,
                'tel1'          =>  $formData->tel1,
                'tel2'          =>  $formData->tel2,
                'siteweb'       =>  $formData->siteweb,
                'facebook'      =>  $formData->facebook,
                'twitter'       =>  $formData->twitter,
                'linkedin'      =>  $formData->linkedin,

                'idnational'    =>  $formData->idnational,
                'rccm'          =>  $formData->rccm,
                'numImpot'      =>  $formData->numImpot,
                'id_user_update'        =>  $formData->connected,
                'busnessName'           =>  $formData->busnessName,
                'codeBusness'           =>  $formData->codeBusness,
                'idSecteur'             =>  $formData->idSecteur,
                'contactNumCode'        =>  $formData->contactNumCode,
                'anneeFondation'        =>  $formData->anneeFondation,
                'numCaisseSocial'       =>  $formData->numCaisseSocial,
                'numInpp'               =>  $formData->numInpp,
                'idForme'               =>  $formData->idForme,
                'numPersonneJuridique'  =>  $formData->numPersonneJuridique,
                
                'slug'          =>  $slug,
                'logo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           
            $stringToSlug=substr($formData->nom, 0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            Entreprise::where('id',$formData->id)->update([
                'idProvince'    =>  $formData->idProvince,
                'ceo'           =>  $formData->ceo,
                'nom'           =>  $formData->nom,
                'email'         =>  $formData->email,
                'adresse'       =>  $formData->adresse,
                'tel1'          =>  $formData->tel1,
                'tel2'          =>  $formData->tel2,
                'siteweb'       =>  $formData->siteweb,
                'facebook'      =>  $formData->facebook,
                'twitter'       =>  $formData->twitter,
                'linkedin'      =>  $formData->linkedin,

                'idnational'    =>  $formData->idnational,
                'rccm'          =>  $formData->rccm,
                'numImpot'      =>  $formData->numImpot,
                'id_user_update'        =>  $formData->connected,
                'busnessName'           =>  $formData->busnessName,
                'codeBusness'           =>  $formData->codeBusness,
                'idSecteur'             =>  $formData->idSecteur,
                'contactNumCode'        =>  $formData->contactNumCode,
                'anneeFondation'        =>  $formData->anneeFondation,
                'numCaisseSocial'       =>  $formData->numCaisseSocial,
                'numInpp'               =>  $formData->numInpp,
                'idForme'               =>  $formData->idForme,
                'numPersonneJuridique'  =>  $formData->numPersonneJuridique,
                
                'slug'          =>  $slug
            ]);
            return $this->msgJson('Modifcation avec succès');

        }

    }


    /*
    *=============================
    *les scripts pour les fichiers
    *=============================
    *
    *
    */
    function getPhotoEntreprise($slug, Request $request)
    {

        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table("photo_entreprise")
            ->join('entreprise','entreprise.id','=','photo_entreprise.id_entreprise')
            ->select("photo_entreprise.id","photo_entreprise.id as id_photo","photo_entreprise.typeFichier as typeFichier", "photo_entreprise.photo",
            "photo_entreprise.created_at");
            $data->where([
                ['photo_entreprise.id_entreprise', 'like', '%'.$query.'%'],
                ['entreprise.slug', $slug],
            ])
            ->orderBy("photo_entreprise.id", "desc")->paginate(6);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table("photo_entreprise")
            ->join('entreprise','entreprise.id','=','photo_entreprise.id_entreprise')
            ->select("photo_entreprise.id","photo_entreprise.id as id_photo","photo_entreprise.typeFichier as typeFichier", "photo_entreprise.photo",
            "photo_entreprise.created_at")                     
            ->where('entreprise.slug', $slug)
            ->orderBy("photo_entreprise.id", "desc")
            ->paginate(6);

            return response()->json([
                'data'  => $data,
            ]);
        }





        
    }

    //ajout des photos
    function AddPhotoEntreprise(Request $request)
    {
      return DB::transaction(function() use($request){

        if (!is_null($request->image)) 
        {

            $formData = json_decode($_POST['data']);

            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/documents/images'), $imageName);
            Photo_entreprise::create([
                'id_entreprise'     => $formData->agentId,
                'typeFichier'       => $formData->typeFichier,
                'photo'             => $imageName
            ]);
           
            return json_encode([
                'data'              =>'Photo ajouté avec succès',
                'typeFichier'       => $formData->typeFichier,
                'imageName'         =>$imageName
            ]);

         }

      });
    }

    function destroyPhotoEntreprise($id)
    {
        //
        $data = Photo_entreprise::where('id', $id)->delete();
        return $this->msgJson("Suppression de l'image avec succès!!!");
    }

    /*
    * scripts pour les videos
    * =======================
    *
    */
    //gets les videos
    function getVideoEntreprise($slug, Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table("video_entreprise")
            ->join('entreprise','entreprise.id','=','video_entreprise.ceo')
            ->select("video_entreprise.id","video_entreprise.id as id_entreprise", "video_entreprise.titre","video_entreprise.url","video_entreprise.description",
                "entreprise.ceo","entreprise.nom","entreprise.logo","entreprise.email",
            "video_entreprise.created_at");
            $data->where([
                ['video_entreprise.titre', 'like', '%'.$query.'%'],
                ['entreprise.slug', $slug],
            ])
            ->orderBy("video_entreprise.id", "desc")->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table("video_entreprise")
            ->join('entreprise','entreprise.id','=','video_entreprise.ceo')
            ->select("video_entreprise.id","video_entreprise.id as id_entreprise", "video_entreprise.titre","video_entreprise.url","video_entreprise.description",
                "entreprise.ceo","entreprise.nom","entreprise.logo","entreprise.email",
            "video_entreprise.created_at")                      
            ->orderBy("video_entreprise.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
        
    }

    function storeVideoEntreprise(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = VideoEntreprise::where("id", $request->id)->update([
                'titre'         =>  $request->titre,
                'description'   =>  $request->description,
                'url'           =>  $request->url
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = VideoEntreprise::create([
                'ceo'           =>  $request->ceo,
                'titre'         =>  $request->titre,
                'description'   =>  $request->description,
                'url'           =>  $request->url
            ]);
            return response()->json(['data'  =>  "Insertion avec succès!!!"]);
         

        }
    }

    function editVideoEntreprise($id)
    {
        //
        $data = VideoEntreprise::where('id', $id)->get();
        return response()->json(['data'  =>  $data]);
    }

    function destroyVideoEntreprise($id)
    {
        //suppression avec succès
        $data = VideoEntreprise::where('id', $id)->delete();
        return $this->msgJson("Suppression des données avec succès!!!");

    }

    //fin script videos

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = DB::table('entreprise') 
        ->join('users' , 'users.id','=','entreprise.ceo')
        ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
        ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
        ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
        "users.name","users.email as email_user","users.telephone","users.avatar",
        "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
        "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
        "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
        "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
        "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
        "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
        "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
        "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
        "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
        "entreprise.created_at","entreprise.updated_at")
        ->where('entreprise.id', $id)->get();

        
        return response()->json(['data'  =>  $data]);

    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $connected)
    {
        //
        $data = Entreprise::where('id',$id)->update([
            'statut'                =>  1,
            'id_user_update'        =>  $connected,
        ]);
        return $this->msgJson('Suppression avec succès!!!');

        // $data = Entreprise::where("id", $id)->delete();

    }
    


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function RestoreData($id, $connected)
    {
        //
        $data = Entreprise::where('id',$id)->update([
            'statut'                =>  0,
            'id_user_delete'        =>  $connected,
        ]);
        return $this->msgJson('Restauration des données avec succès!!!');

    }


    //voir les information des la video
    function getEntrepriseDetails($slug)
    {
        $data = DB::table('entreprise')
        ->join('users' , 'users.id','=','entreprise.ceo')
        ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
        ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
        ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
        "users.name","users.email as email_user","users.telephone","users.avatar",
        "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
        "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
        "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
        "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
        "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
        "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
        "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
        "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
        "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
        "entreprise.created_at","entreprise.updated_at")
        ->where('slug',$slug)->first();

        return response()->json([
            'projectDetail'   => $data
        ]);

    }

   




}
