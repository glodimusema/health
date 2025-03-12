<?php

namespace App\Http\Controllers\Parametres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\{User};
use App\Models\Parametres\{MotSemaine};
use App\Traits\{GlobalMethod,Slug};

use Illuminate\Support\Facades\Mail;

use Auth;
use DB;
use Validator;



class SwotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;
    public function index()
    {
        //

    }

    public function users(Request $request)
    {
         $data = DB::table('users')
        ->join('roles','users.id_role','=','roles.id')
        ->select('users.id as user_id','users.id','users.avatar','users.name','users.email','users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse');
        

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('users.name', 'like', '%'.$query.'%')
            ->orWhere('users.email', 'like', '%'.$query.'%')
            ->orderBy("users.id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        $data->orderBy("users.id", "desc")
        ->paginate(10);

        return response()->json([
            'data'  => $data,
        ]);
    }

    
    function getListUsersLatest()
    {
        $list = [];
        array_push($list, array(
            'usersCeo'      =>  $this->showLatestUsers(2),
            'usersMember'   =>  $this->showLatestUsers(3),
            'usersAdmin'    =>  $this->showLatestUsers(1),
        ));

        return response()->json([
            'data'      =>  $list
        ]);
    }

    function showLatestUsers($id_role){
        \DB::statement("SET SQL_MODE=''");
        $data = DB::table("users")
        ->select("users.id", "users.name","users.id_role", "users.avatar")
        ->take(4)
        ->where('users.id_role', $id_role)
        ->get();
        $list = [];
        $NombreUsers = $this->showCountTableWhere("users","id_role", $id_role);

        foreach ($data as $row) {
            // code...
            array_push($list, array(
                'users' =>  $data,
            ));
        }
        return response()->json([
            'data'          =>  $data,
            'NombreUsers'   =>  $NombreUsers
        ]);

        
        return $list;
    }


    //semaine script
    function showLatestweek(){
        $data = DB::table("mot_semaines")
        ->select("mot_semaines.id", "mot_semaines.message", "mot_semaines.created_at")
        ->take(1)
        ->orderBy('id', 'desc')
        ->get();
        return response()->json([
            'data'  =>  $data
        ]);

        
        return $this->apiData($data->paginate(10));
    }
    function indexMotSemaine(Request $request)
    {
        //
        $data = DB::table("mot_semaines")
        ->select("mot_semaines.id", "mot_semaines.message", "mot_semaines.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('mot_semaines.message', 'like', '%'.$query.'%')
            ->orWhere('mot_semaines.id', 'like', '%'.$query.'%')
            ->orderBy("mot_semaines.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           
        }
        $data->orderBy("mot_semaines.id", "desc")
        ->paginate(10);

        return response()->json([
            'data'  => $data,
        ]);
    }

   
    function storeMotSemaine(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = MotSemaine::where("id", $request->id)->update([
                'message' =>  $request->message
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = MotSemaine::create([
                'message' =>  $request->message
            ]);
            return response()->json(['data'  =>  "Insertion avec succès!!!"]);
         

        }
    }

    function editMotSemaine($id)
    {
        //
        $data = MotSemaine::where('id', $id)->get();
        return response()->json(['data'  =>  $data]);
    }

   
    function destroyMotSemaine($id)
    {
        //
        $data = MotSemaine::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }

    // fin de script

    //les notification de bord
    public function showCountDashbord()
    {
        //
        
        $NombreTotalUtilisateur = $this->showCountTable("users");
        $NombreTotalEntreprise = $this->showCountTable("tcategorieclient");
        $NombreBlog = $this->showCountTableWhere("blogs", "etat", 1);

        $NombreEntrepriseActif = $this->showCountTableWhere("entreprise", "statut", 1);
        $NombreEntrepriseInactif = $this->showCountTableWhere("entreprise", "statut", 0);
      
        $NombreMembre = $this->showCountTableWhere("users","id_role", 3);
        $NombreAdmin = $this->showCountTableWhere("users","id_role", 1);

        $NombreMedecin = $this->showCountTable("tmedecin");
        $NombreMalade = $this->showCountTable("tclient");       //script link
        $NombreOrdonance = $this->showCountTable("tentetelabo_ext");
        $NombreConsultation = $this->showCountTable("tdetailconsultation");
        $NombreMaladeTotal = $this->showCountTable("tclient");

     
        $data =[];
        array_push($data, array(
            'NombreTotalUtilisateur'                =>  $NombreTotalUtilisateur,
          
            'NombreMembre'                          =>  $NombreMembre,
            'NombreAdmin'                           =>  $NombreAdmin,
            'NombreTotalEntreprise'                 =>  $NombreTotalEntreprise,
            "NombreBlog"                            =>  $NombreBlog,
            
            "NombreEntrepriseActif"                 =>  $NombreEntrepriseActif,
            "NombreEntrepriseInactif"               =>  $NombreEntrepriseInactif,
           

            //suite
           //suite
           'NombreMedecin'                  =>  $NombreMedecin,
           'NombreMalade'                  =>  $NombreMalade,
           'NombreOrdonance'                 =>  $NombreOrdonance,          
           "NombreConsultation"                      =>  $NombreConsultation,
           "NombreMaladeTotal"                      =>  $NombreMaladeTotal,
            
           
            
        ));

        return response()->json([
            'data'  =>  $data
        ]);
       
    }

    //les notification de bord
    public function showCountDashbord_tug($id)
    {
        //
        
        $NombreTotalUtilisateur = $this->showCountTable("users");
        $NombreBlog = $this->showCountTableWhere("blogs", "etat", 1);        
        $NombreMembre = $this->showCountTableWhere("users","id_role", 3);
        $NombreAdmin = $this->showCountTableWhere("users","id_role", 1); 
       
        $NombreEntrepriseActif = $this->showNumberDataTableTwoWhere("entreprise", "ceo", $id, "statut", 0);
        $NombreEntrepriseInactif = $this->showNumberDataTableTwoWhere("entreprise", "ceo", $id, "statut", 1);
        $idEntreprise = $this->getIdEntreprise($id);
       
        $data =[];
        array_push($data, array(
            'NombreTotalUtilisateur'                =>  $NombreTotalUtilisateur,            
            'NombreMembre'                          =>  $NombreMembre,
            'NombreAdmin'                           =>  $NombreAdmin,           
            "NombreBlog"                            =>  $NombreBlog,            
            "NombreEntrepriseActif"                 =>  $NombreEntrepriseActif,
            "NombreEntrepriseInactif"               =>  $NombreEntrepriseInactif,
           

           
           
            
        ));

        return response()->json([
            'data'  =>  $data
        ]);
       
    }

    /*
    *statistique des utilisateur
    */

    //
    //stat users by role //
    function statistique_designation_consutstation()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('tdetailconsultation')
         ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
         ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
         ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
         ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
         ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
         ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')                          
        ->selectRaw('sexe_malade, count(*) as nombre')
        ->groupBy("sexe_malade") 
        ->get();
        //
        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->sexe_malade);
            
        }

        return $data;
    }

    function statistique_nombre_consulatation()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('tdetailconsultation')
         ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
         ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
         ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
         ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
         ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
         ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')                          
        ->selectRaw('sexe_malade, count(*) as nombre')
        ->groupBy("sexe_malade") 
        ->get();



        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nombre);
            
        }

        return $data;
    }

    //statistique selon les entreprises
    function stat_consultation_genre()
    {
        
        $data = [];
        $series = [
          array(
            "name"  =>   "Consultations",
            "data"  =>   $this->statistique_nombre_consulatation(),
          )

        ];

        $options = array(

            "chart"   =>  array(
                "id" => "statistique sur les consultation selon les genres",
            ),
            "xaxis"   =>   array(
                "categories" =>  $this->statistique_designation_consutstation()
               
            ),
        );

        array_push($data, array(

            'options'    =>  $options,
            'series'     =>  $series,

        ));

        return $data;

     
    }
    

     /*
    *statistique des utilisateur
    */

    //statistique selon les entreprises
    

    //stat users by role
    function statistique_designation_ordonance_laboratoire()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('tentetelabo_ext')
         ->join('texamen','texamen.id','=','tentetelabo_ext.refExamen')
         ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
         ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
         ->leftjoin('tdetaillabo_ext','tdetaillabo_ext.refEnteteLabo','=','tentetelabo_ext.id')
         ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo_ext.refValeur')
         ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
         ->join('tmouvement','tmouvement.id','=','tentetelabo_ext.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')        
        ->selectRaw('sexe_malade, count(*) as nombre')
        ->groupBy("sexe_malade")
        ->get();
//
        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->sexe_malade);
            
        }

        return $data;
    }

    function statistique_nombre_ordonance_laboratoire()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('tentetelabo_ext')
         ->join('texamen','texamen.id','=','tentetelabo_ext.refExamen')
         ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
         ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
         ->leftjoin('tdetaillabo_ext','tdetaillabo_ext.refEnteteLabo','=','tentetelabo_ext.id')
         ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo_ext.refValeur')
         ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
         ->join('tmouvement','tmouvement.id','=','tentetelabo_ext.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')        
        ->selectRaw('sexe_malade, count(*) as nombre')
        ->groupBy("sexe_malade")
        ->get();



        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nombre);
            
        }

        return $data;
    }


    function stat_ordonance_genre()
    {
        
        $data = [];
        $series = [
          array(
            "name"  =>   "Ordonances",
            "data"  =>   $this->statistique_nombre_ordonance_laboratoire(),
          )

        ];

        $options = array(

            "chart"   =>  array(
                "id" => "statistique sur les entreprises par Secteur",
            ),
            "xaxis"   =>   array(
                "categories" =>  $this->statistique_designation_ordonance_laboratoire()
               
            ),
        );

        array_push($data, array(

            'options'    =>  $options,
            'series'     =>  $series,

        ));

        return $data;

     
    }



















    //statistique selon les roles
    function stat_users()
    {
        
        $data = [];
        $series = [
          array(
            "name"  =>   "Personnes",
            "data"  =>   $this->putstatCategories_table_role(),
          )

        ];

        $options = array(

            "chart"   =>  array(
                "id" => "statistique sur le paiement",
            ),
            "xaxis"   =>   array(
                "categories" =>  $this->putstatOption_table_role()
               
            ),
        );

        array_push($data, array(

            'options'    =>  $options,
            'series'     =>  $series,

        ));

        return $data;

     
    }

    //stat users by role
    function putstatOption_table_role()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('users')
        ->join('roles', 'roles.id', '=','users.id_role')
        ->selectRaw('roles.nom,users.id_role, count(*) as nombre')
        ->groupBy("users.id_role")
        ->get();


        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nom);
            
        }

        return $data;
    }

    function putstatCategories_table_role()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('users')
        ->join('roles', 'roles.id', '=','users.id_role')
        ->selectRaw('roles.nom, users.id_role, count(*) as nombre')
        ->groupBy("users.id_role")
        ->get();


        $data = [];

        $obs = '';

        foreach ($presence as $row) {
            array_push($data, $row->nombre);
            
        }

        return $data;
    }

    //stat par sexe
    function stat_users_sexe_ceo()
    {
        
        $data = [];
        $series = [
          array(
            "name"  =>   "Personnes de sexe",
            "data"  =>   $this->putstatCategories_table_sexe_ceo(),
          )

        ];

        $options = array(

            "chart"   =>  array(
                "id" => "statistique sur le genre",
            ),
            "xaxis"   =>   array(
                "categories" =>  $this->putstatOption_table_sexe_ceo()
               
            ),
        );

        array_push($data, array(

            'options'    =>  $options,
            'series'     =>  $series,

        ));

        return $data;

     
    }

    //stat users by role
    function putstatOption_table_sexe_ceo()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('users')
        ->join('roles', 'roles.id', '=','users.id_role')
        ->selectRaw('roles.nom,users.sexe,users.id_role, count(*) as nombre')
         ->where('users.id_role', 2)
        ->groupBy("users.sexe")
        ->get();


        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->sexe);
            
        }

        return $data;
    }

    function putstatCategories_table_sexe_ceo()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('users')
        ->join('roles', 'roles.id', '=','users.id_role')
        ->selectRaw('roles.nom, users.sexe,users.id_role, count(*) as nombre')
        ->where('users.id_role', 2)
        ->groupBy("users.sexe")
        ->get();


        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nombre);
            
        }

        return $data;
    }

    //statustique sur les gains
    function pnudShowLineChartAssuranceAuto()
    {
        $data = [];
        array_push($data, array(
            'labels'    =>  $this->putstatOption_table_entreprise(),
            'values'    =>  $this->putstatCategories_table_entreprise(),
        ));

        return response()->json([
            'data'  =>  $data
        ]);

    }

    //stat users by assurance autos
    function putstatOption_table_entreprise()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('entreprise')
        ->join('secteurs','secteurs.id','=','entreprise.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprise.idforme')

        ->join('provinces','provinces.id','=','entreprise.idProvince')
        ->join('users','users.id','=','entreprise.ceo')
        ->selectRaw('
            secteurs.nomSecteur,forme_juridiques.nomForme,
            entreprise.idforme, users.name, users.sexe, count(*) as nombre')
        ->groupBy("entreprise.idforme")
        ->get();

        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nomForme);
            
        }

        return $data;
    }

    function putstatCategories_table_entreprise()
    {
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('entreprise')
        ->join('secteurs','secteurs.id','=','entreprise.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprise.idforme')

        ->join('provinces','provinces.id','=','entreprise.idProvince')
        ->join('users','users.id','=','entreprise.ceo')
        ->selectRaw('
            secteurs.nomSecteur,forme_juridiques.nomForme,
            entreprise.idforme, users.name, users.sexe, count(*) as nombre')
        ->groupBy("entreprise.idforme")
        ->get();


        $data = [];

        $obs = '';

        foreach ($presence as $row) {
             array_push($data, $row->nombre);
            
        }

        return $data;
    }
    //fin stat sexe

    function statEntreprise(){
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('entreprise')
        ->join('users', 'users.id', '=','entreprise.ceo')
        ->selectRaw('entreprise.anneeFondation,entreprise.idforme, users.name, users.sexe, count(*) as nombre')
        ->groupBy("entreprise.anneeFondation")
        ->get();


        $data = [];

        foreach ($presence as $row) {
             array_push($data, array(
                "name"  =>  $row->anneeFondation,
                "data"  =>  array(
                    $row->anneeFondation   =>  $row->nombre
                )
                
             ));
            
        }

        return response()->json([
            'data'  =>  $data,
        ]);
    }
    function statEntrepriseSecteur(){
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('entreprise')
        ->join('secteurs','secteurs.id','=','entreprise.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprise.idforme')

        ->join('pays','pays.id','=','entreprise.idProvince')
        ->join('provinces','provinces.id','=','entreprise.idProvince')
        ->join('users','users.id','=','entreprise.ceo')
        ->selectRaw('entreprise.anneeFondation,
            secteurs.nomSecteur,forme_juridiques.nomForme,
            entreprise.idforme, users.name, users.sexe, count(*) as nombre')
        ->groupBy("entreprise.idsecteur")
        ->get();


        $data = [];

        foreach ($presence as $row) {
             array_push($data, array(
                "name"  =>  $row->nomSecteur,
                "data"  =>  array(
                    $row->nomSecteur   =>  $row->nombre
                )
                
             ));
            
        }

        return response()->json([
            'data'  =>  $data,
        ]);
    }

    function statEntreprisePrint(){
        \DB::statement("SET SQL_MODE=''");
         $presence = DB::table('entreprise')
        ->join('users', 'users.id', '=','entreprise.ceo')
        ->selectRaw('entreprise.anneeFondation,entreprise.idforme, users.name, users.sexe, count(*) as nombre')
        ->groupBy("entreprise.anneeFondation")
        ->get();


        $data = [];

        foreach ($presence as $row) {
             array_push($data, array(
                "anneeFondation"       =>   $row->anneeFondation,
                'nbrEntreprise' =>   $this->showCountTableWhere('entreprises',"anneeFondation", $row->anneeFondation),
                
             ));
            
        }

        return response()->json([
            'data'  =>  $data,
        ]);
    }



    //fin statistique

    /**
     * Les etas de sortue
     *
     * @return \Illuminate\Http\Response
     */

    function makepdfEntrepriseMorale(Request $request)
    {

        if ($request->get('slug')) 
        {
            $slug = $request->get('slug');
            $html = $this->getEntrepriseMorale($slug);
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($html);
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream();
            // echo($html);

        }
        else{

        }
        
        
    }

    function getEntrepriseMorale($slug)
    {

        $data = DB::table('entreprise')
        ->join('secteurs','secteurs.id','=','entreprise.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprise.idforme')

        ->join('pays','pays.id','=','entreprise.idProvince')
        ->join('provinces','provinces.id','=','entreprise.idProvince')
        ->join('users','users.id','=','entreprise.ceo')
        
        ->select('entreprise.id as id','entreprise.id as idEntreprise',

            //

            'entreprise.ceo','entreprise.nomEntreprise','entreprise.descriptionEntreprise','entreprise.emailEntreprise','entreprise.adresseEntreprise',
            'entreprise.telephoneEntreprise','entreprise.solutionEntreprise','entreprise.idsecteur','entreprise.idforme','entreprise.etat',
            'entreprise.idProvince','entreprise.idProvince','entreprise.anneeFondation','entreprise.facebook','entreprise.linkedin','entreprise.twitter','entreprise.siteweb','entreprise.rccm',
            'entreprise.invPersonnel','entreprise.invHub','entreprise.invRecherche','entreprise.chiffreAffaire','entreprise.nbremploye','entreprise.slug','entreprise.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprise.created_at')
        ->where([
            ['entreprise.etat', 1],
            ['entreprise.slug', $slug],
        ])
        ->get();

        $output='
        <div style="border:1px solid black;padding:0px;">
         <h3 align="center" style="color:blue;">REPUBLIQUE DEMOCRATIQUE DU CONGO <br/> LISTE DES PERSONNES MORALE INSCRITES A LA PLATEFORME <br/> <span style="text-decoration:underline;">PNUD JINNOV </span></h3>
        
           <div align="center"> LA LISTE ENTIERE DES  ENTREPRISES  ET LEURS PDG AU SYSTEME </div>
           <hr /><br/><br/>
        <table align="center" cellpadding="7" cellspacing="0" border="1" width="525">
          <tr style="font-weight:bold; background:#ccc;" >
           
            <td>Nom de l\'entreprise</td>
            <td>Cordonnées de l\'entreprise</td>
            <td>RCCM</td>
            <td>Nom du PDG</td>
            <td>Téléphone</td>
            <td>Pays</td>
           
          </tr>';

        $count=1;
    
        foreach ($data as $row) 
        {

            $output.=' 
              <tr>
              
               <td> 
                    '.$row->nomEntreprise.'
               </td>
               <td> 
                    
                    <a href="mailto:'.$row->emailEntreprise.'">'.$row->emailEntreprise.'</a>
                   
                   <br />
                   <a href="tel:'.$row->telephoneEntreprise.'">'.$row->telephoneEntreprise.'</a>
               </td>
               <td>'.$row->rccm.'</td>
               <td>'.$row->name.'</td>
               <td>'.$row->telephone.' </td>
               <td>'.$row->nomPays.' </td>
               
                
              </tr>

            ';

            $output.=' 
              <tr>
               <td colspan="2"> 
                    Description de l\'entreprise
               </td>
              
               <td colspan="4"> 
                    '.$row->descriptionEntreprise.'
               </td>
               
              </tr>

              <tr>
               <td colspan="2"> 
                    Solution de l\'entreprise
               </td>
              
               <td colspan="4"> 
                    '.$row->solutionEntreprise.'
               </td>

               <tr>
                   <td colspan="2"> 
                        Secteur d\'activité
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->nomSecteur.'
                   </td>
               
               </tr>

               <tr>
                   <td colspan="2"> 
                        Forme juridique
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->nomForme.'
                   </td>
               
               </tr>

               <tr>
                   <td colspan="2"> 
                        Nombre d\'employé
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->nbremploye.' employés
                   </td>
               
               </tr>

               <tr>
                   <td colspan="2"> 
                       anneeFondation au programme
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->anneeFondation.'
                   </td>
               
               </tr>

               
               <tr>
                   <td colspan="2"> 
                        Province
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->nomProvince.'
                   </td>
               
               </tr>
               <tr>
                   <td colspan="2"> 
                        Ville
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->adresseEntreprise.'
                   </td>
               
               </tr>

               <tr>
                   <td colspan="2"> 
                       Visibilité sur les réseaux sociaux
                   </td>
                  
                   <td colspan="4"> 
                        <div><b>Facebook: <b> <a style="color:blue;" href="'.$row->facebook.'">'.$row->facebook.'</a></div><br/>
                        <div><b>Twitter: <b> <a style="color:blue;" href="'.$row->twitter.'">'.$row->twitter.'</a></div><br/>
                        <div><b>Linkedin: <b> <a style="color:blue;" href="'.$row->linkedin.'">'.$row->linkedin.'</a></div><br/>
                   </td>
               
               </tr>

               <tr>
                   <td colspan="5" align="center"> 
                       Merci de faire partir au programme jinnov
                   </td>
                  
                   <td colspan="1" style="background:#ccc;"> 
                        
                   </td>
               
               </tr>

            ';

            

            

        }

        // $total = $this->showCountNotification("etat", 1, "entreprises");
        // $output.='
        //   <tr>
        //     <td colspan="4" align="right"><b>Nombre total d\'entreprise</b></td>
        //     <td colspan="2"> '.$total.' Entreprise(s)</td>
        //   </tr>
          
        // ';


        $output.='</table>';

        $output .='
        <p>
        <br />
        </p>
            <p style="position:relative;left:500px;">

              Fait à Goma le '.date('Y-m-d').'
            </p>
        <br /><br /></div>
        ';
       
        return $output; 

    }

    function makepdfListeEntrepriseMorale(Request $request)
    {

        if ($request->get('anneeFondation')) 
        {
            $anneeFondation = $request->get('anneeFondation');
            $html = $this->getListeEntrepriseMorale($anneeFondation);
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($html);
            // $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream();
            // echo($html);

        }
        else{

        }
        
        
    }

    function getListeEntrepriseMorale($anneeFondation)
    {

        $data = DB::table('entreprise')
        ->join('secteurs','secteurs.id','=','entreprise.idsecteur')
        ->join('forme_juridiques','forme_juridiques.id','=','entreprise.idforme')

        ->join('pays','pays.id','=','entreprise.idProvince')
        ->join('provinces','provinces.id','=','entreprise.idProvince')
        ->join('users','users.id','=','entreprise.ceo')
        
        ->select('entreprise.id as id','entreprise.id as idEntreprise',

            //

            'entreprise.ceo','entreprise.nomEntreprise','entreprise.descriptionEntreprise','entreprise.emailEntreprise','entreprise.adresseEntreprise',
            'entreprise.telephoneEntreprise','entreprise.solutionEntreprise','entreprise.idsecteur','entreprise.idforme','entreprise.etat',
            'entreprise.idProvince','entreprise.idProvince','entreprise.anneeFondation','entreprise.facebook','entreprise.linkedin','entreprise.twitter','entreprise.siteweb','entreprise.rccm',
            'entreprise.invPersonnel','entreprise.invHub','entreprise.invRecherche','entreprise.chiffreAffaire','entreprise.nbremploye','entreprise.slug','entreprise.logo',

            //forme
            'forme_juridiques.nomForme','secteurs.nomSecteur',
            //users
            'users.name','users.email','users.avatar','users.telephone','users.adresse',
            //

            'provinces.nomProvince','pays.nomPays', 'entreprise.created_at')
        ->where([
            ['entreprises.etat', 1],
            ['entreprises.anneeFondation', $anneeFondation],
        ])
        ->get();

        $output='
        <div style="border:1px solid black;padding:0px;">
         <h3 align="center" style="color:blue;">REPUBLIQUE DEMOCRATIQUE DU CONGO <br/> LISTE DES PERSONNES MORALE INSCRITES A LA PLATEFORME <br/> <span style="text-decoration:underline;">PNUD JINNOV </span></h3>
        
           <div align="center"> LA LISTE ENTIERE DES  ENTREPRISES  ET LEURS PDG AU SYSTEME anneeFondation '.$anneeFondation.'</div>
           <hr /><br/><br/>
        <table align="center" cellpadding="7" cellspacing="0" border="1" width="525">
          <tr style="font-weight:bold; background:#ccc;" >
           
            <td>Nom de l\'entreprise</td>
            <td>Cordonnées de l\'entreprise</td>
            <td>RCCM</td>
            <td>Nom du PDG</td>
            <td>Téléphone</td>
            <td>Pays</td>
           
          </tr>';

        $count=1;
    
        foreach ($data as $row) 
        {

            $output.=' 
              <tr>
              
               <td> 
                    '.$row->nomEntreprise.'
               </td>
               <td> 
                    
                    <a href="mailto:'.$row->emailEntreprise.'">'.$row->emailEntreprise.'</a>
                   
                   <br />
                   <a href="tel:'.$row->telephoneEntreprise.'">'.$row->telephoneEntreprise.'</a>
               </td>
               <td>'.$row->rccm.'</td>
               <td>'.$row->name.'</td>
               <td>'.$row->telephone.' </td>
               <td>'.$row->nomPays.' </td>
               
                
              </tr>

            ';

            $output.=' 
              <tr>
               <td colspan="2"> 
                    Description de l\'entreprise
               </td>
              
               <td colspan="4"> 
                    '.$row->descriptionEntreprise.'
               </td>
               
              </tr>

              <tr>
               <td colspan="2"> 
                    Solution de l\'entreprise
               </td>
              
               <td colspan="4"> 
                    '.$row->solutionEntreprise.'
               </td>

               <tr>
                   <td colspan="2"> 
                        Secteur d\'activité
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->nomSecteur.'
                   </td>
               
               </tr>

               <tr>
                   <td colspan="2"> 
                        Forme juridique
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->nomForme.'
                   </td>
               
               </tr>

               <tr>
                   <td colspan="2"> 
                        Nombre d\'employé
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->nbremploye.' employés
                   </td>
               
               </tr>

               <tr>
                   <td colspan="2"> 
                       Edition au programme
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->edition.'
                   </td>
               
               </tr>

               
               <tr>
                   <td colspan="2"> 
                        Province
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->nomProvince.'
                   </td>
               
               </tr>
               <tr>
                   <td colspan="2"> 
                        Ville
                   </td>
                  
                   <td colspan="4"> 
                        '.$row->adresseEntreprise.'
                   </td>
               
               </tr>

               <tr>
                   <td colspan="2"> 
                       Visibilité sur les réseaux sociaux
                   </td>
                  
                   <td colspan="4"> 
                        <div><b>Facebook: <b> <a style="color:blue;" href="'.$row->facebook.'">'.$row->facebook.'</a></div><br/>
                        <div><b>Twitter: <b> <a style="color:blue;" href="'.$row->twitter.'">'.$row->twitter.'</a></div><br/>
                        <div><b>Linkedin: <b> <a style="color:blue;" href="'.$row->linkedin.'">'.$row->linkedin.'</a></div><br/>
                   </td>
               
               </tr>

               <tr>
                   <td colspan="5" align="center"> 
                       Merci de faire partir au programme jinnov
                   </td>
                  
                   <td colspan="1" style="background:#ccc;"> 
                        
                   </td>
               
               </tr>

            ';

            

            

        }

        $total = $this->showCountNotificationWhere("etat", 1, "entreprises","edition", $edition);
        $output.='
          <tr>
            <td colspan="4" align="right"><b>Nombre total d\'entreprise</b></td>
            <td colspan="2"> '.$total.' Entreprise(s)</td>
          </tr>
          
        ';


        $output.='</table>';

        $output .='
        <p>
        <br />
        </p>
            <p style="position:relative;left:500px;">

              Fait à Goma le '.date('Y-m-d').'
            </p>
        <br /><br /></div>
        ';
       
        return $output; 

    }


    
}
