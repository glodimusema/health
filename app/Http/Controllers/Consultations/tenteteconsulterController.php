<?php

namespace App\Http\Controllers\Consultations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultations\tenteteconsulter;
use DB;
use Carbon\Carbon;

class tenteteconsulterController extends Controller
{
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

            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",'nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt')
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            // ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ]) 

            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            
            




            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])




            ->orderBy("tenteteconsulter.id", "desc")          
            ->paginate(80);

            return response()->json([
                    'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([                           
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([                        
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([                           
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([                        
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([                           
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([                        
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }

    public function all_jour(Request $request)
    {  
        $current = Carbon::now()->format('Y-m-d');

        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
                   
            

            
            ->orwhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])





            ->orwhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])



            ->orderBy("tenteteconsulter.id", "desc")          
            ->paginate(80);

            return response()->json([
                    'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([                           
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation',date("Y-m-d")],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orwhere([                          
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation',date("Y-m-d")],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([                           
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation',date("Y-m-d")],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([                          
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation',date("Y-m-d")],
                ['tenteteconsulter.deleted','NON']
            ])
            
            ->orwhere([                           
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation',date("Y-m-d")],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([                          
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation',date("Y-m-d")],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }

    public function all_attente(Request $request)
    {    
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orwhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            
            ->orwhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orwhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])  
            
            
            ->orwhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orwhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])


            ->orderBy("tenteteconsulter.id", "desc")          
            ->paginate(80);

            return response()->json([
                    'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([                           
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([                           
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([                           
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }

    public function all_attente_jour(Request $request)
    {
        $current = Carbon::now()->format('Y-m-d');

        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])

            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])


            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['TypeOrientation', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])



                              
            ->orderBy("tenteteconsulter.id", "desc")          
            ->paginate(80);

            return response()->json([
                    'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([                           
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([                           
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([                           
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }






    public function filter_all(Request $request)
    { 
        $current = Carbon::now()->format('Y-m-d');

        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');


            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                           
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([  
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                      
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([  
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                         
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([ 
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                       
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([  
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                         
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([ 
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                       
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);

    

        }
        else {
            // code...
        }
        
        


    }

    public function filter_all_jour(Request $request)
    { 
        $current = Carbon::now()->format('Y-m-d');

        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');

            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([  
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                             
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orwhere([ 
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                             
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([      
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                         
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([   
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                           
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])    
            ->orwhere([      
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                         
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Validé'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([   
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                           
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['categoriemaladiemvt','ABONNE(E)'],             
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])        
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);


        }


    }

    public function filter_all_attente(Request $request)
    {
        
        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');


            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([  
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                          
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([    
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                        
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([    
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                        
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);





        }else{}




    }

    public function filter_all_attente_jour(Request $request)
    {
        $current = Carbon::now()->format('Y-m-d');
        
        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            
            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            // ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            // ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture',
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([ 
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                            
                ['Statut','Encours'],              
                ['TypeOrientation','CONSULTATIONS'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([  
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                           
                ['Statut','Encours'],              
                ['TypeOrientation','DENTISTERIE'],              
                ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orwhere([  
                ['tenteteconsulter.created_at','>=', $date1],
                ['tenteteconsulter.created_at','<=', $date2],                           
                ['Statut','Encours'],              
                ['TypeOrientation','MATERNITE'],              
                // ['statutentetecons','Attente'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);

        
        }
        else{}
       

    }










    public function urgences_jour(Request $request)
    {
        $current = Carbon::now()->format('Y-m-d');

        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture','refLitUrgence','finUrgence',
            'nom_lit','refSalle',"nom_salle","PrixSalle",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])              
            ->orderBy("tenteteconsulter.id", "desc")          
            ->paginate(80);

            return response()->json([
                    'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture','refLitUrgence','finUrgence',
            'nom_lit','refSalle',"nom_salle","PrixSalle",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([                     
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],              
                ['tenteteconsulter.dateConsultation','>=',$current],
                ['tenteteconsulter.deleted','NON']
            ])   
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }



    public function urgences(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture','refLitUrgence','finUrgence',
            'nom_lit','refSalle',"nom_salle","PrixSalle",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],
                ['tenteteconsulter.deleted','NON']
            ])               
            ->orderBy("tenteteconsulter.id", "desc")          
            ->paginate(80);

            return response()->json([
                    'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture','refLitUrgence','finUrgence',
            'nom_lit','refSalle',"nom_salle","PrixSalle",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([                     
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],
                ['tenteteconsulter.deleted','NON']
            ])               
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function urgences_attente(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture','refLitUrgence','finUrgence',
            'nom_lit','refSalle',"nom_salle","PrixSalle",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['noms_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],
                ['tenteteconsulter.deleted','NON']
            ])
            ->orWhere([
                ['specialite_medecin', 'like', '%'.$query.'%'],              
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],
                ['tenteteconsulter.deleted','NON']
            ])               
            ->orderBy("tenteteconsulter.id", "desc")          
            ->paginate(80);

            return response()->json([
                    'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture','refLitUrgence','finUrgence',
            'nom_lit','refSalle',"nom_salle","PrixSalle",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([                     
                ['Statut','Encours'],              
                ['TypeOrientation','URGENCES'],
                ['tenteteconsulter.deleted','NON']
            ])   
            ->orderBy("tenteteconsulter.id", "desc")  
            ->paginate(80);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }



    public function fetch_entete_triage(Request $request,$refDetailTriage)
    { 
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture','refLitUrgence','finUrgence',
            'nom_lit','refSalle',"nom_salle","PrixSalle",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],  
                ['refDetailTriage',$refDetailTriage],            
                ['Statut','Encours'],
                ['tenteteconsulter.deleted','NON']
            ])     
            ->orderBy("tenteteconsulter.id", "desc")
            ->paginate(80);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tenteteconsulter')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
            ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
            //MALADE
            ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
            "tenteteconsulter.author",'statutentetecons','cloture','refLitUrgence','finUrgence',
            'nom_lit','refSalle',"nom_salle","PrixSalle",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
            ->where([                
                ['refDetailTriage',$refDetailTriage],            
                ['Statut','Encours'],
                ['tenteteconsulter.deleted','NON']
            ]) 
            ->orderBy("tenteteconsulter.id", "desc")
            ->paginate(80);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    //mes scripts
    function fetch_list_medecin()
    {

        $data = DB::table('tmedecin')->select("id",'matricule_medecin',"noms_medecin",'specialite_medecin','fonction_medecin')->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_entete($id)
    {

        $data = DB::table('tenteteconsulter')
        ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
        ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
        ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
        ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')

        ->leftjoin('tlit','tlit.id','=','tenteteconsulter.refLitUrgence')
        ->leftjoin('tsalle','tsalle.id','=','tlit.refSalle')
        //MALADE 
        ->select("tenteteconsulter.id",'parcours','TypeOrientation','refDetailTriage','refMedecin','dateConsultation',
        "tenteteconsulter.author",'statutentetecons','cloture','refLitUrgence','finUrgence',
        'nom_lit','refSalle',"nom_salle","PrixSalle",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
        'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('TIMESTAMPDIFF(DAY, tenteteconsulter.created_at, (DATE_ADD(CURDATE(), INTERVAL 1 DAY))) as duree')
        ->where('tenteteconsulter.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_entete(Request $request)
    {

        $categoriemaladiemvt='';
        $maxid = DB::table('tdetailtriage')
        ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
        ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
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
        ->select("tdetailtriage.id","refEnteteTriage",'plainte_triage','antecedent_trige','cas_triage',
        "Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        'plainte_triage','antecedent_trige','cas_triage','categoriemaladiemvt',
        "tdetailtriage.author","tdetailtriage.created_at","tdetailtriage.updated_at",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->Where('tdetailtriage.id',$request->refDetailTriage)
        ->get();
        foreach ($maxid as $list) {
            $categoriemaladiemvt= $list->categoriemaladiemvt;
        }

        if($categoriemaladiemvt == 'PRIVE(E)')
        {
            if($request->TypeOrientation == 'URGENCES')
            {
                $data = tenteteconsulter::create([
                    'refDetailTriage'       =>  $request->refDetailTriage,
                    'refMedecin'    =>  $request->refMedecin,
                    'TypeOrientation'    =>  $request->TypeOrientation,
                    'dateConsultation'    =>  $request->dateConsultation,    
                    'cloture'    =>  $request->cloture,
                    'refLitUrgence'    =>  $request->refLitUrgence,
                    'statutentetecons'    =>  'Validé',
                    'parcours'    => 'Consultation',       
                    'author'       =>  $request->author
                ]);

                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }
            else if($request->TypeOrientation == 'CONSULTATIONS')
            {
                $data = tenteteconsulter::create([
                    'refDetailTriage'       =>  $request->refDetailTriage,
                    'refMedecin'    =>  $request->refMedecin,
                    'TypeOrientation'    =>  $request->TypeOrientation,
                    'dateConsultation'    =>  $request->dateConsultation,    
                    'cloture'    =>  $request->cloture,
                    'refLitUrgence'    =>  1,
                    'statutentetecons'    =>  'Validé',
                    'parcours'    => 'Consultation',       
                    'author'       =>  $request->author
                ]);
                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }
            else if($request->TypeOrientation == 'DENTISTERIE')
            {
                $data = tenteteconsulter::create([
                    'refDetailTriage'       =>  $request->refDetailTriage,
                    'refMedecin'    =>  $request->refMedecin,
                    'TypeOrientation'    =>  $request->TypeOrientation,
                    'dateConsultation'    =>  $request->dateConsultation,    
                    'cloture'    =>  $request->cloture,
                    'refLitUrgence'    =>  1,
                    'statutentetecons'    =>  'Validé',
                    'parcours'    => 'Consultation',       
                    'author'       =>  $request->author
                ]);
                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }
            else if($request->TypeOrientation == 'MATERNITE')
            {
                $data = tenteteconsulter::create([
                    'refDetailTriage'       =>  $request->refDetailTriage,
                    'refMedecin'    =>  $request->refMedecin,
                    'TypeOrientation'    =>  $request->TypeOrientation,
                    'dateConsultation'    =>  $request->dateConsultation,    
                    'cloture'    =>  $request->cloture,
                    'refLitUrgence'    =>  1,
                    'statutentetecons'    =>  'Validé',
                    'parcours'    => 'Consultation',       
                    'author'       =>  $request->author
                ]);
                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }

           

        }
        if($categoriemaladiemvt == 'ABONNE(E)')
        {
            if($request->TypeOrientation == 'URGENCES')
            {
                $data = tenteteconsulter::create([
                    'refDetailTriage'       =>  $request->refDetailTriage,
                    'refMedecin'    =>  $request->refMedecin,
                    'TypeOrientation'    =>  $request->TypeOrientation,
                    'dateConsultation'    =>  $request->dateConsultation,    
                    'cloture'    =>  $request->cloture,
                    'refLitUrgence'    =>  $request->refLitUrgence, 
                    'statutentetecons'    =>  'Attente',
                    'parcours'    => 'Consultation',     
                    'author'       =>  $request->author
                ]);

                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }
            else if($request->TypeOrientation == 'CONSULTATIONS')
            {
                $data = tenteteconsulter::create([
                    'refDetailTriage'       =>  $request->refDetailTriage,
                    'refMedecin'    =>  $request->refMedecin,
                    'TypeOrientation'    =>  $request->TypeOrientation,
                    'dateConsultation'    =>  $request->dateConsultation,    
                    'cloture'    =>  $request->cloture,
                    'refLitUrgence'    =>  1, 
                    'statutentetecons'    =>  'Attente',
                    'parcours'    => 'Consultation',     
                    'author'       =>  $request->author
                ]);

                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }
            else if($request->TypeOrientation == 'DENTISTERIE')
            {
                $data = tenteteconsulter::create([
                    'refDetailTriage'       =>  $request->refDetailTriage,
                    'refMedecin'    =>  $request->refMedecin,
                    'TypeOrientation'    =>  $request->TypeOrientation,
                    'dateConsultation'    =>  $request->dateConsultation,    
                    'cloture'    =>  $request->cloture,
                    'refLitUrgence'    =>  1, 
                    'statutentetecons'    =>  'Attente',
                    'parcours'    => 'Consultation',     
                    'author'       =>  $request->author
                ]);

                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }
            else if($request->TypeOrientation == 'MATERNITE')
            {
                $data = tenteteconsulter::create([
                    'refDetailTriage'       =>  $request->refDetailTriage,
                    'refMedecin'    =>  $request->refMedecin,
                    'TypeOrientation'    =>  $request->TypeOrientation,
                    'dateConsultation'    =>  $request->dateConsultation,    
                    'cloture'    =>  $request->cloture,
                    'refLitUrgence'    =>  1, 
                    'statutentetecons'    =>  'Attente',
                    'parcours'    => 'Consultation',     
                    'author'       =>  $request->author
                ]);

                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }
            //Attente
           
        }


       
      
    }

    function update_entete(Request $request, $id)
    {
        $data = tenteteconsulter::where('id', $id)->update([
            'refDetailTriage'       =>  $request->refDetailTriage,
            'refMedecin'    =>  $request->refMedecin,
            'TypeOrientation'    =>  $request->TypeOrientation,
            'dateConsultation'    =>  $request->dateConsultation, 
            'statutentetecons'    =>  $request->statutentetecons,                   
            'cloture'    =>  $request->cloture,
            'refLitUrgence'    =>  $request->refLitUrgence,                      
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_entete_medecin(Request $request, $id)
    {
        $data = tenteteconsulter::where('id', $id)->update([            
            'refMedecin'    =>  $request->refMedecin,               
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_cloture(Request $request,$id)
    {
        $data = tenteteconsulter::where('id', $id)->update([
            'cloture'    =>  $request->cloture,                   
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

    }

    function update_fin_urgence(Request $request,$id)
    {
        $data = tenteteconsulter::where('id', $id)->update([
            'finUrgence'    =>  $request->finUrgence,                   
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

    }

    function update_statutcons(Request $request, $id)
    {
        $data = tenteteconsulter::where('id', $id)->update([
            'statutentetecons'    =>  $request->statutentetecons,                   
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_entete($id)
    {
        $data = tenteteconsulter::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
