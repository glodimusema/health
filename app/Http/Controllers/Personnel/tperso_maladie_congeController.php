<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_maladie_conge;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_maladie_congeController extends Controller
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

    

            $query = $this->Gquery($request);
            $data = DB::table('tperso_maladie_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_maladie_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
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
            ->select("tperso_maladie_conge.id","autreDetail","annexeMalade","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_maladie_conge.author","refAnne","refEnteteConge",   

            "dateAffectation","numCimak","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","dateJourAbsent","dateDernierJour",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateDernierJour, CURDATE()) as age_medecin')   
            ->where([
                ['noms_medecin', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_entete_conge.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'=>$data
            ]);
           

        }
        else{
            $data = DB::table('tperso_maladie_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_maladie_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
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
            ->select("tperso_maladie_conge.id","autreDetail","annexeMalade","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_maladie_conge.author","refAnne","refEnteteConge",   

            "dateAffectation","numCimak","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","dateJourAbsent","dateDernierJour",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateDernierJour, CURDATE()) as age_medecin')  
            ->orderBy("tperso_entete_conge.id", "desc")          
            ->paginate(10);


            return response()->json([
                'data'=>$data
            ]);
        }

    }


    public function fetch_entete_maladieConge(Request $request,$refEnteteConge)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_maladie_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_maladie_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
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
            ->select("tperso_maladie_conge.id","autreDetail","annexeMalade","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_maladie_conge.author","refAnne","refEnteteConge",   

            "dateAffectation","numCimak","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","dateJourAbsent","dateDernierJour",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateDernierJour, CURDATE()) as age_medecin')  
            ->where([
                ['noms_medecin', 'like', '%'.$query.'%'],
                ['refEnteteConge',$refEnteteConge]
            ])                    
            ->orderBy("tperso_entete_conge.id", "desc")
            ->paginate(10);

            return response()->json([
               'data'=> $data
            ]);          

        }
        else{
      
            $data = DB::table('tperso_maladie_conge')
            ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_maladie_conge.refEnteteConge')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
            ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
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
            ->select("tperso_maladie_conge.id","autreDetail","annexeMalade","dateDernierJour","dateRetour","controle",
            "agent","remplacement","chefService","hierarchie","tperso_maladie_conge.author","refAnne","refEnteteConge",   

            "dateAffectation","numCimak","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
            "noms_medecin","dateJourAbsent","dateDernierJour",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateDernierJour, CURDATE()) as age_medecin')  
            ->Where('refEnteteConge',$refEnteteConge)    
            ->orderBy("tperso_entete_conge.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'=> $data
             ]);          
 
        }

    }    
    

    function fetch_single($id)
    {

        $data = DB::table('tperso_maladie_conge')
        ->join('tperso_entete_conge','tperso_entete_conge.id','=','tperso_maladie_conge.refEnteteConge')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_conge.refAffectation')
        ->join('tperso_annee','tperso_annee.id','=','tperso_entete_conge.refAnne')
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
        ->select("tperso_maladie_conge.id","autreDetail","annexeMalade","dateDernierJour","dateRetour","controle",
        "agent","remplacement","chefService","hierarchie","tperso_maladie_conge.author","refAnne","refEnteteConge",   

        "dateAffectation","numCimak","numCNSS","autresDetail",
        "refAgent","refServicePerso","refCategorieAgent","matricule_medecin",
        "noms_medecin","dateJourAbsent","dateDernierJour",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateDernierJour, CURDATE()) as age_medecin')  
        ->where('tperso_maladie_conge.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

//id,refEnteteConge,autreDetail,annexeMalade,author

    function insert_data(Request $request)
    {

        if (!is_null($request->image)) 
        {
           $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName); 
   
            $data= tperso_maladie_conge::create([
                'refEnteteConge'       =>  $formData->refEnteteConge,
                'autreDetail'    =>  $formData->autreDetail,
                'annexeMalade'    =>  $imageName,
                'author'       =>  $formData->author           
            ]);
   
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
        }
        else{
           $formData = json_decode($_POST['data']);
           $data= tperso_maladie_conge::create([
            'refEnteteConge'       =>  $formData->refEnteteConge,
            'autreDetail'    =>  $formData->autreDetail,
            'annexeMalade'    =>  'avatar.png',
            'author'       =>  $formData->author 
        ]);
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
   
        }
    }


    function update_data(Request $request, $id)
    {
        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName);
         
           $data= tperso_maladie_conge::where('id',$formData->id)->update([
            'refEnteteConge'       =>  $formData->refEnteteConge,
            'autreDetail'    =>  $formData->autreDetail,
            'annexeMalade'    =>  $imageName,
            'author,'       =>  $formData->author
           ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
        }
        else{
            $formData = json_decode($_POST['data']);
            $data= tperso_maladie_conge::where('id',$formData->id)->update([
                'refEnteteConge'       =>  $formData->refEnteteConge,
                'autreDetail'    =>  $formData->autreDetail,
                'annexeMalade'    =>  'avatar.png',
                'author,'       =>  $formData->author
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
   
        }
    }


    function delete_data($id)
    {
        $data = tperso_maladie_conge::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
