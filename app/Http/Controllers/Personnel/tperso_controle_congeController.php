<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_controle_conge;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_controle_congeController extends Controller
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
            $data = DB::table('tperso_controle_conge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_controle_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_controle_conge.refAnne')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_controle_conge.id","nbrJour","name_annee","tperso_controle_conge.author","refAffectation","refAnne",

            "dateAffectation","numCimak","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->where([
                ['noms_medecin', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_controle_conge.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'=>$data
            ]);       
        }
        else{
            $data = DB::table('tperso_controle_conge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_controle_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_controle_conge.refAnne')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_controle_conge.id","nbrJour","name_annee","tperso_controle_conge.author","refAffectation","refAnne",

            "dateAffectation","numCimak","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
            "tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->orderBy("tperso_controle_conge.id", "desc")          
            ->paginate(10);


            return response()->json([
                'data'=>$data
            ]);
        }

    }


    public function fetch_affect_controle(Request $request,$refAffectation)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_controle_conge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_controle_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_controle_conge.refAnne')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_controle_conge.id","nbrJour","name_annee","tperso_controle_conge.author","refAffectation","refAnne",

            "dateAffectation","numCimak","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")                         
            ->where([
                ['noms_medecin', 'like', '%'.$query.'%'],
                ['refAffectation',$refAffectation]
            ])                    
            ->orderBy("tperso_controle_conge.id", "desc")
            ->paginate(10);

            return response()->json([
               'data'=> $data
            ]);          

        }
        else{
      
            $data = DB::table('tperso_controle_conge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_controle_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_controle_conge.refAnne')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_controle_conge.id","nbrJour","name_annee","tperso_controle_conge.author","refAffectation","refAnne",

            "dateAffectation","numCimak","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")                           
            ->Where('refAffectation',$refAffectation)    
            ->orderBy("tperso_controle_conge.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'=> $data
             ]);          
 
        }

    }    
    
    function fetch_single($id)
    {

        $data = DB::table('tperso_controle_conge')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_controle_conge.refAffectation')
        ->join('tperso_annee','tperso_annee.id','=','tperso_controle_conge.refAnne')
        ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_controle_conge.id","nbrJour","name_annee","tperso_controle_conge.author","refAffectation",
        "refAnne","dateAffectation","numCimak","numCNSS","autresDetail",
        "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
        "noms_medecin","lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->where('tperso_controle_conge.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

// id,refAffectation,refAnne,nbrJour,author

    function insert_data(Request $request)
    {      
        $data = tperso_controle_conge::create([
            'refAffectation'       =>  $request->refAffectation,
            'refAnne'    =>  $request->refAnne,
            'nbrJour'    =>  $request->nbrJour,
            'author'       =>  $request->author,
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!"
        ]);

    }


    function update_data(Request $request, $id)
    {
        $data = tperso_controle_conge::where('id', $id)->update([
            'refAffectation'       =>  $request->refAffectation,
            'refAnne'    =>  $request->refAnne,
            'nbrJour'    =>  $request->nbrJour,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_controle_conge::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
