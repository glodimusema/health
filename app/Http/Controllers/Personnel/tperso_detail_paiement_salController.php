<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_detail_paiement_sal;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_detail_paiement_salController extends Controller
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
        //
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_detail_paiement_sal')
            ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
            ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tperso_rubrique.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refmois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            // ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_detail_paiement_sal.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","taux","tperso_entete_paiement.refAffectation","refParametre",
            "tperso_affectation_agent.refCategorieAgent",'tperso_detail_paiement_sal.author',
            "name_mois","name_annee","dateFiche","refAnne",
            "refmois","dateAffectation","numCimak","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",
            "refAgent","refServicePerso","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
            "tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent",
            "tperso_rubrique.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "modepaie","refBanque",'refBanque',"tconf_banque.nom_banque","tconf_banque.numerocompte",
            'tconf_banque.nom_mode')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')   
            ->where([
                ['noms_medecin', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_detail_paiement_sal.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'=>$data
            ]);
           

        }
        else{
            $data = DB::table('tperso_detail_paiement_sal')
            ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
            ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tperso_rubrique.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refmois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            // ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_detail_paiement_sal.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","taux","tperso_entete_paiement.refAffectation","refParametre",
            "tperso_affectation_agent.refCategorieAgent",'tperso_detail_paiement_sal.author',
            "name_mois","name_annee","dateFiche","refAnne",
            "refmois","dateAffectation","numCimak","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",
            "refAgent","refServicePerso","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
            "tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent",
            "tperso_rubrique.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "modepaie","refBanque",'refBanque',"tconf_banque.nom_banque","tconf_banque.numerocompte",
            'tconf_banque.nom_mode')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')   
            ->orderBy("tperso_detail_paiement_sal.id", "desc")          
            ->paginate(10);


            return response()->json([
                'data'=>$data
            ]);
        }

    }


    public function fetch_entete_Detail(Request $request,$refEntetePaie)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_detail_paiement_sal')
            ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
            ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tperso_rubrique.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refmois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            // ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_detail_paiement_sal.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","taux","tperso_entete_paiement.refAffectation","refParametre",
            "tperso_affectation_agent.refCategorieAgent",'tperso_detail_paiement_sal.author',
            "name_mois","name_annee","dateFiche","refAnne",
            "refmois","dateAffectation","numCimak","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",
            "refAgent","refServicePerso","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
            "tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent",
            "tperso_rubrique.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "modepaie","refBanque",'refBanque',"tconf_banque.nom_banque","tconf_banque.numerocompte",
            'tconf_banque.nom_mode')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')   
            ->where([
                ['noms_medecin', 'like', '%'.$query.'%'],
                ['refEntetePaie',$refEntetePaie]
            ])                    
            ->orderBy("tperso_detail_paiement_sal.id", "desc")
            ->paginate(10);

            return response()->json([
               'data'=> $data
            ]);          

        }
        else{
      
            $data = DB::table('tperso_detail_paiement_sal')
            ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
            ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tperso_rubrique.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refmois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
            // ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_detail_paiement_sal.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","taux","tperso_entete_paiement.refAffectation","refParametre",
            "tperso_affectation_agent.refCategorieAgent",'tperso_detail_paiement_sal.author',
            "name_mois","name_annee","dateFiche","refAnne",
            "refmois","dateAffectation","numCimak","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",
            "refAgent","refServicePerso","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
            "tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent",
            "tperso_rubrique.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "modepaie","refBanque",'refBanque',"tconf_banque.nom_banque","tconf_banque.numerocompte",
            'tconf_banque.nom_mode')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')   
            ->Where('refEntetePaie',$refEntetePaie)    
            ->orderBy("tperso_detail_paiement_sal.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'=> $data
             ]);          
 
        }

    }    
    

    function fetch_single($id)
    {

        $data = DB::table('tperso_detail_paiement_sal')
        ->join('tperso_entete_paiement','tperso_entete_paiement.id','=','tperso_detail_paiement_sal.refEntetePaie')
        ->join('tperso_detail_affectation_ribrique','tperso_detail_affectation_ribrique.id','=','tperso_detail_paiement_sal.refDetailAffectRibrique')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
        ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie') 
        ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
        ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_parametre_rubrique.refCategorieAgent')
        ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tperso_rubrique.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
        ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refmois')
        ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
        ->join('tmedecin','tmedecin.id','=','tperso_affectation_agent.refAgent')
        // ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_detail_paiement_sal.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
        "montant","taux","tperso_entete_paiement.refAffectation","refParametre",
        "tperso_affectation_agent.refCategorieAgent",'tperso_detail_paiement_sal.author',
        "name_mois","name_annee","dateFiche","refAnne",
        "refmois","dateAffectation","numCimak","numCNSS","numcpteBanque",
        "numImpot","BanqueAgant","autresDetail",
        "refAgent","refServicePerso","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
        "tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","name_serv_perso","name_categorie_service","name_categorie_agent",
        "tperso_rubrique.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
        "modepaie","refBanque",'refBanque',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')   
        ->where('tperso_detail_paiement_sal.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    //id,refEntetePaie,refDetailAffectRibrique,taux,author

    function insert_data(Request $request)
    { 

        $taux=0;
        $tauxList = DB::table('tfin_taux')
        ->select("tfin_taux.id","tfin_taux.montant_taux","tfin_taux.created_at")
        ->get();
        foreach ($tauxList as $listTaux) {
            $taux= $listTaux->montant_taux;
        }

        $data = tperso_detail_paiement_sal::create([
            'refEntetePaie'       =>  $request->refEntetePaie,
            'refDetailAffectRibrique'    =>  $request->refDetailAffectRibrique,
            'taux'    =>  $taux,
            'author'  =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_detail_paiement_sal::where('id', $id)->update([
            'refEntetePaie'       =>  $request->refEntetePaie,
            'refDetailAffectRibrique'    =>  $request->refDetailAffectRibrique,
            'author'  =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_detail_paiement_sal::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
