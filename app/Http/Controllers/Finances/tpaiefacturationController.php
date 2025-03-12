<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_paiementfacture;
use App\Models\Finances\tfin_cloture_caisse;
use App\Models\tdepense;

use DB;

class tpaiefacturationController extends Controller
{
    public function index()
    {
        return 'hello';
    }
//
    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }
   
    public function all(Request $request)
    {
        //tfin_paiementfacture
               
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tfin_paiementfacture')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
            ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            // ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            // ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            // ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            // ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            // ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
           
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            // ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            // ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            // ->join('communes' , 'communes.id','=','quartiers.idCommune')
            // ->join('villes' , 'villes.id','=','communes.idVille')
            // ->join('provinces' , 'provinces.id','=','villes.idProvince')
            // ->join('pays' , 'pays.id','=','provinces.idPays')
            
                //MALADE
            ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
            'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
            "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte',
            // 'nom_souscompte',
            // 'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            // 'refTypecompte','refPosition','nom_classe','numero_classe',
            // 'nom_typeposition',"nom_typecompte",
            'refMouvement','refUniteProduction','refMedecin',
            'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
            "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug",
            // "nomAvenue",
            // "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            // "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            // "numeroMaison_malade"
            "fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            // ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
            // ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->where('noms', 'like', '%'.$query.'%')
            ->orWhere([
                ['tfin_paiementfacture.id', 'like', '%'.$query.''],
                ['tfin_paiementfacture.deleted','NON']
            ])
            ->orderBy("tfin_entetefacturation.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tfin_paiementfacture')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
            ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            // ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            // ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            // ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            // ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            // ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
           
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            // ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            // ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            // ->join('communes' , 'communes.id','=','quartiers.idCommune')
            // ->join('villes' , 'villes.id','=','communes.idVille')
            // ->join('provinces' , 'provinces.id','=','villes.idProvince')
            // ->join('pays' , 'pays.id','=','provinces.idPays')
            
                //MALADE
            ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
            'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
            "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte',
            // 'nom_souscompte',
            // 'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            // 'refTypecompte','refPosition','nom_classe','numero_classe',
            // 'nom_typeposition',"nom_typecompte",
            'refMouvement','refUniteProduction','refMedecin',
            'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
            "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug",
            // "nomAvenue",
            // "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            // "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            // "numeroMaison_malade"
            "fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            // ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
            // ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->where([['tfin_paiementfacture.deleted','NON']])
            ->orderBy("tfin_paiementfacture.id", "desc")              
            ->paginate(10);
                return response()->json([
                        'data'  => $data,
                    ]);
            }

    }


    public function fetch_paie_facturation(Request $request,$refEnteteFacturation)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tfin_paiementfacture')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                //MALADE
            ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
            'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
            "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe',
            'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
            'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
            "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEnteteFacturation',$refEnteteFacturation],
                ['tmouvement.Statut','Encours'],
                ['tfin_paiementfacture.deleted','NON']
            ])                      
            ->orderBy("tfin_paiementfacture.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tfin_paiementfacture')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                //MALADE
            ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
            'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
            "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe',
            'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
            'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
            "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->where([
                ['refEnteteFacturation',$refEnteteFacturation],
                ['tmouvement.Statut','Encours'],
                ['tfin_paiementfacture.deleted','NON']
            ])      
            ->orderBy("tfin_paiementfacture.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 

    function fetch_single_paie($id)
    {

        $data = DB::table('tfin_paiementfacture')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            //MALADE
        ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
        'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
        "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe',
        'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
        'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
        "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
        "tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->where('tfin_paiementfacture.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    function insert_paie(Request $request)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', date('Y-m-d'))         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == date('Y-m-d'))
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp !!! Veuillez prendre la date du jour suivant !!!",
            ]);
       }
       else
       {
            $montant_taux=0;
            $taux = DB::table('tfin_taux')->get();
    
            foreach ($taux as $tau) {
                $montant_taux= $tau->montant_taux;
            }


            $montantpaie = 0;
            $factureList = DB::table('tfin_entetefacturation')            
            ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
            ->where([
                ['tfin_entetefacturation.id', $request->refEnteteFacturation]
            ])
            ->get();
            foreach ($factureList as $liste_facture) {
                $montantpaie= $liste_facture->RestePaie;
            }
    
            if($montantpaie > 0)
            {
                $data = tfin_paiementfacture::create([
                    'refEnteteFacturation'       =>  $request->refEnteteFacturation,
                    'montantpaie'       =>  $request->montantpaie,
                    'datepaie'       =>  date('Y-m-d'),
                    'modepaie'       =>  $request->modepaie,
                    'libellepaie'       =>  $request->libellepaie,                     
                    'author'       =>  $request->author,
                    'montant_taux'       =>  $montant_taux,
                    'refBanque'       =>  $request->refBanque,
                    'numeroBordereau'       =>  $request->numeroBordereau
                ]);
    
    
                $data3 = DB::update(
                    'update tfin_entetefacturation set paie = paie + (:paiement) where id = :refEnteteFacturation',
                    ['paiement' => $request->montantpaie,'refEnteteFacturation' => $request->refEnteteFacturation]
                );
    
                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]); 
            }
            else{
                return response()->json([
                    'data'  =>  "Cette facture est déja soldée svp!!!",
                ]);
            }
    

       }

    }


    function insert_paie_direct(Request $request)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', date('Y-m-d'))         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == date('Y-m-d'))
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp !!! Veuillez prendre la date du jour suivant !!!",
            ]);
       }
       else
       {
            $modepaie='CASH';
            $refBanque=$request->refBanque;
            $montant_taux=0;
            $montantpaie = 0;
            $taux = DB::table('tfin_taux')->get();            
    
            foreach ($taux as $tau) {
                $montant_taux= $tau->montant_taux;
            }
            
            $factureList = DB::table('tfin_entetefacturation')            
            ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
            ->where([
                ['tfin_entetefacturation.id', $request->refEnteteFacturation]
            ])
            ->get();
            foreach ($factureList as $liste_facture) {
                $montantpaie= $liste_facture->RestePaie;
            }
    
            if($montantpaie > 0)
            {
                $data = tfin_paiementfacture::create([
                    'refEnteteFacturation'       =>  $request->refEnteteFacturation,
                    'montantpaie'       =>  $montantpaie,
                    'datepaie'       =>  date('Y-m-d'),
                    'modepaie'       =>  $modepaie,
                    'libellepaie'       =>  'Paiement cash',                     
                    'author'       =>  $request->author,
                    'montant_taux'       =>  $montant_taux,
                    'refBanque'       =>  $refBanque,
                    'numeroBordereau'       =>  '00000'
                ]);
    
    
                $data3 = DB::update(
                    'update tfin_entetefacturation set paie = paie + (:paiement) where id = :refEnteteFacturation',
                    ['paiement' => $montantpaie,'refEnteteFacturation' => $request->refEnteteFacturation]
                );
    
                return response()->json([
                    'data'  =>  "Paiement effectué avec succès!!!",
                ]); 
            }
            else{
                return response()->json([
                    'data'  =>  "Cette facture est déja soldée svp!!!",
                ]);
            }
    

       }

    }


    function update_paie(Request $request, $id)
    {
       $datetest='';
       $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', date('Y-m-d'))         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == date('Y-m-d'))
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);
       }
       else
       {
            $montant_taux=0;
            $taux = DB::table('tfin_taux')->get();
    
            foreach ($taux as $tau) {
                $montant_taux= $tau->montant_taux;
            }


            $idFacture=0;
            $montant_last=0;
            $montantpaie=$request->montantpaie;
    
            $deleteds = DB::table('tfin_paiementfacture')
            ->selectRaw('montantpaie as prixTotal')
            ->Where('id',$id)->get(); 
            foreach ($deleteds as $deleted) {
                $idFacture = $deleted->refEnteteFacturation;
                $montant_last = $deleted->prixTotal;
            }
                
            $data3 = DB::update(
                'update tfin_entetefacturation set paie = paie - (:montant_last) + (:montantpaie) where id = :refEnteteFacturation',
                ['montant_last' => $montant_last,'montantpaie' => $montantpaie,'refEnteteFacturation' => $idFacture]
            );



            $data = tfin_paiementfacture::where('id', $id)->update([
                'refEnteteFacturation'       =>  $request->refEnteteFacturation,
                'montantpaie'       =>  $request->montantpaie,
                'modepaie'       =>  $request->modepaie,
                'libellepaie'       =>  $request->libellepaie,                     
                'author'       =>  $request->author,
                'montant_taux'       =>  $montant_taux,
                'refBanque'       =>  $request->refBanque,
                'numeroBordereau'       =>  $request->numeroBordereau
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!",
            ]);
       }



    }

    function delete_paie($id)
    {

        $idFacture=0;
        $montants=0;

        $deleteds = DB::table('tfin_paiementfacture')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteFacturation;
            $montants = $deleted->montantpaie;
        }
        $data3 = DB::update(
            'update tfin_entetefacturation set paie = paie - (:paiement) where id = :refEnteteFacturation',
            ['paiement' => $montants,'refEnteteFacturation' => $idFacture]
        );


        $data = tfin_paiementfacture::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
    
    function cloturer_Caisse(Request $request)
    {
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_cloture)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_cloture)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);
       }
       else
       {
                $sommation=0;

                $data6 = DB::table('tfin_paiementfacture')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
                ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
                ->join('tclient','tclient.id','=','tmouvement.refMalade')
                ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
                ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                
                ->selectRaw('ROUND(SUM(montantpaie),0) as TotalPaie')
                ->where([
                    ['datepaie','=', $request->date_cloture],
                    ['tfin_paiementfacture.deleted','NON']
                ])                  
                ->get();    
    
                
                foreach ($data6 as $row) 
                { 
                  $sommation = $row->TotalPaie;
                }
    
                $TotalPaie=0;
                $datepaie='';
                $refBanque=0;
                $modepaie='';
                $montant_taux=0;
                
                $taux = DB::table('tfin_taux')->get();
        
                foreach ($taux as $tau) {
                    $montant_taux= $tau->montant_taux;
                }
            
            $data2 = DB::table('tfin_paiementfacture')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            
            ->select('datepaie','refBanque','modepaie')
            ->selectRaw('ROUND(SUM(montantpaie),0) as TotalPaie')
            ->where([
                ['datepaie','=', $request->date_cloture],
                ['tfin_paiementfacture.deleted','NON']
            ])
            ->groupby('datepaie','refBanque','modepaie')    
            ->get();    

            
            foreach ($data2 as $row) 
            { 
                                                    
                $TotalPaie=$row->TotalPaie;
                $datepaie=$row->datepaie;
                $refBanque=$row->refBanque;  
                $modepaie=$row->modepaie;
                        
                $data4 = tdepense::create([
                    'montant'       =>  $TotalPaie,
                    'montantLettre'    =>  'USD',
                    'motif'    =>  'RECETTES JOURNALIERES',
                    'dateOperation'    => $datepaie,
                    'refMvt'    =>  1,
                    'refCompte'    =>  $request->refSscompte,
                    'modepaie'    =>  $modepaie,
                    'refBanque'    =>  $refBanque,
                    'numeroBordereau'    =>  '00000000',
                    'taux_dujour'    =>  $montant_taux,
                    'AcquitterPar'    =>  'Encours',
                    'StatutAcquitterPar'    =>  'NON',
                    'DateAcquitterPar'    =>  date('Y-m-d'),
                    'ApproCoordi'    =>  'Encours',
                    'StatutApproCoordi'    =>  'NON',
                    'DateApproCoordi'    =>  date('Y-m-d'),
                    'numeroBE'    =>  '0000',
                    'author'       =>  $request->author
                ]);
            }
            $data5 = tfin_cloture_caisse::create([
                    'refSscompte'       =>  $request->refSscompte,
                    'date_cloture'    =>  $request->date_cloture,
                    'montant_cloture' =>   $TotalPaie,
                    'taux_dujour'    => $montant_taux,            
                    'author'       =>  $request->author
            ]);
            return response()->json([
                    'data'  =>  "La Caisse est cloturée pour cette date avec succès!!!",
            ]);

       }



    }








}
