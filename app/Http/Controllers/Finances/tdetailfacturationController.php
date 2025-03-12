<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_detailfacturation;
use App\Models\Finances\tfin_entetefacturation;
use App\Models\Finances\tfin_paiementfacture;
use App\Models\Finances\tfin_cloture_caisse;

use DB;

class tdetailfacturationController extends Controller
{
    public function index()
    {
        return 'hello';
    }
//
    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));      
    }
   
    public function all(Request $request)
    {
               
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tfin_detailfacturation')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                //MALADE 
            ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
            'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
            'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
            "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",'pourcentageConvention',
            'categoriemaladiemvt',"ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->selectRaw('(quantite*prixunitaire) as prixTotal')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tfin_detailfacturation.deleted','NON']
            ])
            ->orWhere('codeFacture', 'like', '%'.$query.'%')            
            ->orderBy("tfin_detailfacturation.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tfin_detailfacturation')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                //MALADE
            ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
            'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
            'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
            "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->selectRaw('(quantite*prixunitaire) as prixTotal')  
            ->where([['tfin_detailfacturation.deleted','NON']])           
            ->paginate(10);
                return response()->json([
                        'data'  => $data,
                    ]);
            }

    }


    public function fetch_detail_entete(Request $request,$refEnteteFacturation)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tfin_detailfacturation')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                //MALADE
            ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
            'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
            'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
            "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->selectRaw('(quantite*prixunitaire) as prixTotal')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEnteteFacturation',$refEnteteFacturation],
                ['tmouvement.Statut','Encours'],
                ['tfin_detailfacturation.deleted','NON']
            ])                      
            ->orderBy("tfin_entetefacturation.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tfin_detailfacturation')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                //MALADE
            ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
            'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
            'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
            "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->selectRaw('(quantite*prixunitaire) as prixTotal')
            ->where([
                ['refEnteteFacturation',$refEnteteFacturation],
                ['tmouvement.Statut','Encours'],
                ['tfin_detailfacturation.deleted','NON']
            ]) 
            ->orderBy("tfin_entetefacturation.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 

    function fetch_single_entete($id)
    {

        $data = DB::table('tfin_detailfacturation')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
            //MALADE
        ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
        'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
        'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
        "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->selectRaw('(quantite*prixunitaire) as prixTotal')
        ->where('tfin_detailfacturation.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

//

    function fetch_detailfacture_for_entete($refEnteteFacturation)
    {

        $data = DB::table('tfin_detailfacturation')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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

        ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
        'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
        'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
        "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->selectRaw('(quantite*prixunitaire) as prixTotal')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->where([
            ['refEnteteFacturation', $refEnteteFacturation],
            ['tfin_detailfacturation.deleted','NON']
        ])
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }



   //'id','refEnteteFacturation','refProduit','quantite','prixunitaire','author'
    function insert_entete(Request $request)
    {
        $montant_taux=0;
        $taux = DB::table('tfin_taux')->get();
 
        foreach ($taux as $tau) {
            $montant_taux= $tau->montant_taux;
        }

        $prixunitaire=$request->prixunitaire;
        $quantite=$request->quantite;
        $organisationAbonne='';
        $refMouvement=0;
        $refCategorieSociete=0;
        $idFacture=$request->refEnteteFacturation;

        $data2 = DB::table('tfin_entetefacturation')
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
            //MALADE
        ->select('refMouvement','organisationAbonne')
        ->where('tfin_entetefacturation.id', $request->refEnteteFacturation)         
        ->get();
        foreach ($data2 as $list) {
           $organisationAbonne= $list->organisationAbonne;
           $refMouvement= $list->refMouvement;
        }

        $data3 = DB::table('tconf_organisationabone')
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
        ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
         'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
         'name_categorie_societe','author',"tconf_organisationabone.created_at")
        ->where('nom_org', $organisationAbonne)         
        ->get();
        foreach ($data3 as $list) {
           $refCategorieSociete= $list->refCategorieSociete;
        }

        $data4 = DB::table('tfin_produit')   
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
        'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')
        ->where([
            ['refCategorieSociete',$refCategorieSociete],
            ['tfin_produit.id',$request->refProduit]
        ])                 
        ->get();
        foreach ($data4 as $list) {
            $prixunitaire= $list->prix_produit;
        }
       
        $data = tfin_detailfacturation::create([
            'refEnteteFacturation'       =>  $request->refEnteteFacturation,
            'refProduit'       =>  $request->refProduit,
            'quantite'       =>  $request->quantite,
            'prixunitaire'       =>  $prixunitaire,                              
            'author'       =>  $request->author,
            'montant_taux'       =>  $montant_taux
        ]);

        $data3 = DB::update(
            'update tfin_entetefacturation set montant = montant + (:prixunitaire * :quantite) where id = :refEnteteFacturation',
            ['prixunitaire' => $prixunitaire,'quantite' => $quantite,'refEnteteFacturation' => $idFacture]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

        
    }


    function update_entete(Request $request, $id)
    {

        $montant_taux=0;
        $taux = DB::table('tfin_taux')->get();
 
        foreach ($taux as $tau) {
            $montant_taux= $tau->montant_taux;
        }

        $idFacture=0;
        $montant_last=0;
        $prixunitaire=$request->prixunitaire;
        $quantite=$request->quantite;

        $deleteds = DB::table('tfin_detailfacturation')
        ->selectRaw('(quantite*prixunitaire) as prixTotal')
        ->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteFacturation;
            $montant_last = $deleted->prixTotal;
        }

        $data3 = DB::update(
            'update tfin_entetefacturation set montant = montant - (:montant_last) + (:prixunitaire * :quantite) where id = :refEnteteFacturation',
            ['montant_last' => $montant_last,'prixunitaire' => $prixunitaire,'quantite' => $quantite,'refEnteteFacturation' => $idFacture]
        );

        $data = tfin_detailfacturation::where('id', $id)->update([
            'refEnteteFacturation'       =>  $request->refEnteteFacturation,
            'refProduit'       =>  $request->refProduit,
            'quantite'       =>  $request->quantite,
            'prixunitaire'       =>  $request->prixunitaire,                              
            'author'       =>  $request->author,
            'montant_taux'       =>  $montant_taux
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_entete($id)
    {
        $idFacture=0;
        $prixunitaire=0;
        $quantite=0;

        $deleteds = DB::table('tfin_detailfacturation')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteFacturation;
            $prixunitaire = $deleted->prixunitaire;
            $quantite = $deleted->quantite;
        }

        $data3 = DB::update(
            'update tfin_entetefacturation set montant = montant - (:prixunitaire * :quantite) where id = :refEnteteFacturation',
            ['prixunitaire' => $prixunitaire,'quantite' => $quantite,'refEnteteFacturation' => $idFacture]
        );

        $data = tfin_detailfacturation::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }




    function insert_dataGlobal(Request $request)
    {
        $categoriemaladiemvt='';
        $mouvementList = DB::table('tmouvement')            
        ->select('categoriemaladiemvt')
        ->where([
            ['tmouvement.id',$request->refMouvement]
        ])
        ->get();
        foreach ($mouvementList as $liste_mvt) {
            $categoriemaladiemvt= $liste_mvt->categoriemaladiemvt;
        }

        $statuts='';
        if($categoriemaladiemvt == 'ABONNE(E)'){

            $statuts='CREDIT';           
        }
        else
        {
            $statuts='CASH';
        } 

        $data = tfin_entetefacturation::create([
            'refMouvement'       =>  $request->refMouvement,
            'refUniteProduction'       =>  $request->refUniteProduction,
            'refMedecin'       =>  $request->refMedecin,
            'datefacture'       =>  date('Y-m-d'),
            'statut'    =>  $statuts,                           
            'author'       =>  $request->author
        ]);

        $idmax=0;
        $maxid = DB::table('tfin_entetefacturation')       
        ->selectRaw('MAX(tfin_entetefacturation.id) as code_entete')
        ->where('tfin_entetefacturation.refMouvement', $request->refMouvement)
        ->get();
        foreach ($maxid as $list) {
            $idmax = $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $montant_taux=0;
            $taux = DB::table('tfin_taux')->get();
     
            foreach ($taux as $tau) {
                $montant_taux= $tau->montant_taux;
            }
    
            $prixunitaire=$data['prixunitaire'];
            $quantite=$data['quantite'];
            $organisationAbonne='';
            $refMouvement=0;
            $refCategorieSociete=0;
            $idFacture = $idmax;
    
            $data2 = DB::table('tfin_entetefacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            //MALADE
            ->select('refMouvement','organisationAbonne')
            ->where('tfin_entetefacturation.id', $idmax)         
            ->first();
            if ($data2) {
               $organisationAbonne= $data2->organisationAbonne;
               $refMouvement= $data2->refMouvement;
            }
    
            $data3 = DB::table('tconf_organisationabone')
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
            ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
             'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
             'name_categorie_societe','author',"tconf_organisationabone.created_at")
            ->where('nom_org', $organisationAbonne)         
            ->first();
            if ($data3) {
               $refCategorieSociete= $data3->refCategorieSociete;
            }
    
            $data4 = DB::table('tfin_produit')   
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')

            ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','nom_typeproduit')
            ->where([
                ['refCategorieSociete',$refCategorieSociete],
                ['tfin_produit.id',$request->refProduit]
            ])                 
            ->first();
            if ($data4) {
                $prixunitaire= $data4->prix_produit;
            }
           
            $data = tfin_detailfacturation::create([
                'refEnteteFacturation'       =>  $idmax,
                'refProduit'       =>  $data['refProduit'],
                'quantite'       =>  $data['quantite'],
                'prixunitaire'       =>  $prixunitaire,                              
                'author'       =>  $request->author,
                'montant_taux'       =>  $montant_taux
            ]);
    
            $data3 = DB::update(
                'update tfin_entetefacturation set montant = montant + (:prixunitaire * :quantite) where id = :refEnteteFacturation',
                ['prixunitaire' => $prixunitaire,'quantite' => $quantite,'refEnteteFacturation' => $idFacture]
            );
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }
    
    function insert_dataGlobalCash(Request $request)
    {
        $categoriemaladiemvt='';
        $mouvementList = DB::table('tmouvement')            
        ->select('categoriemaladiemvt')
        ->where([
            ['tmouvement.id',$request->refMouvement]
        ])
        ->get();
        foreach ($mouvementList as $liste_mvt) {
            $categoriemaladiemvt= $liste_mvt->categoriemaladiemvt;
        }

        $statuts='';
        if($categoriemaladiemvt == 'ABONNE(E)'){

            $statuts='CREDIT';           
        }
        else
        {
            $statuts='CASH';
        } 

        $data = tfin_entetefacturation::create([
            'refMouvement'       =>  $request->refMouvement,
            'refUniteProduction'       =>  $request->refUniteProduction,
            'refMedecin'       =>  $request->refMedecin,
            'datefacture'       =>  date('Y-m-d'),
            'statut'    =>  $statuts,                           
            'author'       =>  $request->author
        ]);

        $idmax=0;
        $maxid = DB::table('tfin_entetefacturation')       
        ->selectRaw('MAX(tfin_entetefacturation.id) as code_entete')
        ->where('tfin_entetefacturation.refMouvement', $request->refMouvement)
        ->get();
        foreach ($maxid as $list) {
            $idmax = $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $montant_taux=0;
            $taux = DB::table('tfin_taux')->get();
     
            foreach ($taux as $tau) {
                $montant_taux= $tau->montant_taux;
            }
    
            $prixunitaire=$data['prixunitaire'];
            $quantite=$data['quantite'];
            $organisationAbonne='';
            $refMouvement=0;
            $refCategorieSociete=0;
            $idFacture = $idmax;
    
            $data2 = DB::table('tfin_entetefacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            //MALADE
            ->select('refMouvement','organisationAbonne')
            ->where('tfin_entetefacturation.id', $idmax)         
            ->first();
            if ($data2) {
               $organisationAbonne= $data2->organisationAbonne;
               $refMouvement= $data2->refMouvement;
            }
    
            $data3 = DB::table('tconf_organisationabone')
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
            ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
             'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
             'name_categorie_societe','author',"tconf_organisationabone.created_at")
            ->where('nom_org', $organisationAbonne)         
            ->first();
            if ($data3) {
               $refCategorieSociete= $data3->refCategorieSociete;
            }
    
            $data4 = DB::table('tfin_produit')   
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')

            ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','nom_typeproduit')
            ->where([
                ['refCategorieSociete',$refCategorieSociete],
                ['tfin_produit.id',$request->refProduit]
            ])                 
            ->first();
            if ($data4) {
                $prixunitaire= $data4->prix_produit;
            }
           
            $data = tfin_detailfacturation::create([
                'refEnteteFacturation'       =>  $idmax,
                'refProduit'       =>  $data['refProduit'],
                'quantite'       =>  $data['quantite'],
                'prixunitaire'       =>  $prixunitaire,                              
                'author'       =>  $request->author,
                'montant_taux'       =>  $montant_taux
            ]);
    
            $data3 = DB::update(
                'update tfin_entetefacturation set montant = montant + (:prixunitaire * :quantite) where id = :refEnteteFacturation',
                ['prixunitaire' => $prixunitaire,'quantite' => $quantite,'refEnteteFacturation' => $idFacture]
            );
        }

        //PAIEMENT DE LA FACTURE ===================================================================
        
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', date('Y-m-d'))         
       ->first();    
       if ($data3) 
       {                           
          $datetest=$data3->date_cloture;          
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
            $refBanque=1;
            $montant_taux=0;
            $montantpaie = 0;
            $taux = DB::table('tfin_taux')->get();            
    
            foreach ($taux as $tau) {
                $montant_taux= $tau->montant_taux;
            }
            
            $factureList = DB::table('tfin_entetefacturation')            
            ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
            ->where([
                ['tfin_entetefacturation.id', $idmax]
            ])
            ->get();
            foreach ($factureList as $liste_facture) {
                $montantpaie= $liste_facture->RestePaie;
            }
    
            $data = tfin_paiementfacture::create([
                'refEnteteFacturation'       =>  $idmax,
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
                ['paiement' => $montantpaie,'refEnteteFacturation' => $idmax]
            ); 

       }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function insert_paiement_cash(Request $request, $id)
    {
        // $current = Carbon::now();
        //PAIEMENT DE LA FACTURE ===================================================================
        
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
            $refBanque=1;
            $montant_taux=0;
            $montantpaie = 0;
            $taux = DB::table('tfin_taux')->first();            
    
            if ($taux) {
                $montant_taux= $taux->montant_taux;
            }
            
            $factureList = DB::table('tfin_entetefacturation')            
            ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
            ->where([
                ['tfin_entetefacturation.id', $id]
            ])
            ->first();
            if ($factureList) {
                $montantpaie= $factureList->RestePaie;
            }
    
            if($montantpaie > 0)
            {
                $data = tfin_paiementfacture::create([
                    'refEnteteFacturation'       =>  $id,
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
                    ['paiement' => $montantpaie,'refEnteteFacturation' => $id]
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
















}
