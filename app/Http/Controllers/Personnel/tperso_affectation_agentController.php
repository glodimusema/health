<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_affectation_agent;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_affectation_agentController extends Controller
{
    use GlobalMethod, Slug  ;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_agent')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id","dateAffectation","numCimak","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail","tperso_affectation_agent.author",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')   
            ->where([
                ['noms_medecin', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'=>$data
            ]);
           

        }
        else{
            $data = DB::table('tperso_affectation_agent')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id","dateAffectation","numCimak","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail","tperso_affectation_agent.author",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin') 
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')   
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(10);


            return response()->json([
                'data'=>$data
            ]);
        }

    }


    public function fetch_affect_agent(Request $request,$refAgent)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_agent')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id","dateAffectation","numCimak","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail","tperso_affectation_agent.author",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin') 
            ->where([
                ['noms_medecin', 'like', '%'.$query.'%'],
                ['refAgent',$refAgent]
            ])                    
            ->orderBy("tperso_affectation_agent.id", "desc")
            ->paginate(10);

            return response()->json([
               'data'=> $data
            ]);          

        }
        else{
      
            $data = DB::table('tperso_affectation_agent')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_affectation_agent.id","dateAffectation","numCimak","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail","tperso_affectation_agent.author",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')               
            ->Where('refAgent',$refAgent)    
            ->orderBy("tperso_affectation_agent.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'=> $data
             ]);          
 
        }

    }    

    
    function fetch_list_medecin()
    {
        $data = DB::table('tmedecin')->select("id",'matricule_medecin',"noms_medecin",'specialite_medecin','fonction_medecin')->get();

        return response()->json([
            'data'  => $data
        ]);
    }
    

    function fetch_single($id)
    {

        $data = DB::table('tperso_affectation_agent')
        ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_affectation_agent.id","dateAffectation","numCimak","numCNSS","numcpteBanque",
        "numImpot","BanqueAgant","autresDetail","tperso_affectation_agent.author",
        "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')   
        ->where('tperso_affectation_agent.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }



    function fetch_affectation_agent()
    {

        $data = DB::table('tperso_affectation_agent')
        ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_affectation_agent.id","dateAffectation","numCimak","numCNSS","numcpteBanque",
        "numImpot","BanqueAgant","autresDetail","tperso_affectation_agent.author",
        "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    // ,"numcpteBanque","numImpot","BanqueAgant"
    // id,refAgent,refServicePerso,refCategorieAgent,dateAffectation,numCimak,numCNSS,autresDetail,author

    function insert_data(Request $request)
    {
       
        $data = tperso_affectation_agent::create([
            'refAgent'       =>  $request->refAgent,
            'refServicePerso'    =>  $request->refServicePerso,
            'refCategorieAgent'    =>  $request->refCategorieAgent,
            'dateAffectation'    =>  $request->dateAffectation,    
            'numCimak'    =>  $request->numCimak,
            'numCNSS'    =>  $request->numCNSS,
            'numImpot'    =>  $request->numImpot,
            'numcpteBanque'    =>  $request->numcpteBanque,
            'BanqueAgant'    =>  $request->BanqueAgant,       
            'autresDetail'       =>  $request->autresDetail,
            'author'       =>  $request->author,
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_affectation_agent::where('id', $id)->update([
            'refAgent'       =>  $request->refAgent,
            'refServicePerso'    =>  $request->refServicePerso,
            'refCategorieAgent'    =>  $request->refCategorieAgent,
            'dateAffectation'    =>  $request->dateAffectation,    
            'numCimak'    =>  $request->numCimak,
            'numCNSS'    =>  $request->numCNSS, 
            'numImpot'    =>  $request->numImpot,
            'numcpteBanque'    =>  $request->numcpteBanque,
            'BanqueAgant'    =>  $request->BanqueAgant,       
            'autresDetail'       =>  $request->autresDetail,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_affectation_agent::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
