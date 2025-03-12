<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tdetailtriage;
use App\Models\tentetetriage;
use App\Models\Consultations\tenteteconsulter;
use DB;

class tdetailtriageController extends Controller
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

            $data = DB::table('tdetailtriage')
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
            "tdetailtriage.author","tdetailtriage.created_at","tdetailtriage.updated_at","refMouvement",
            "dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
            ['noms', 'like', '%'.$query.'%'],
            ['tdetailtriage.deleted','NON']
            ])            
            ->orderBy("tdetailtriage.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tdetailtriage')
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
            "tdetailtriage.author","tdetailtriage.created_at","tdetailtriage.updated_at","refMouvement",
            "dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['tdetailtriage.deleted','NON']])
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_detailtriage_entete(Request $request,$refEnteteTriage)
    {     
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdetailtriage')
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
            "Poids","Taille","TA","Temperature","FC","FR",
            "Oxygene",'plainte_triage','antecedent_trige','cas_triage',
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
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEnteteTriage',$refEnteteTriage],
                ['tdetailtriage.deleted','NON']
            ])           
            ->orderBy("tdetailtriage.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tdetailtriage')
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
            "Poids","Taille","TA","Temperature","FC","FR",
            "Oxygene",'plainte_triage','antecedent_trige','cas_triage',
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
            ->Where([
            ['refEnteteTriage',$refEnteteTriage],
            ['tdetailtriage.deleted','NON']
            ])  
            ->orderBy("tdetailtriage.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

   

    function fetch_single_detailTriage($id)
    {

        $data = DB::table('tdetailtriage')
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
        'plainte_triage','antecedent_trige','cas_triage',
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
        ->Where('tdetailtriage.id',$id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    function fetch_entete_detailTriage2($refEnteteTriage)
    {

        $data = DB::table('tdetailtriage')
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
        "Poids","Taille","TA","Temperature",
        'plainte_triage','antecedent_trige','cas_triage',"FC","FR","Oxygene",
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
        ->Where([
        ['refEnteteTriage',$refEnteteTriage],
        ['tdetailtriage.deleted','NON']
        ])
        ->orderBy("tdetailtriage.id", "desc")
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }



    function fetch_max_adetail_triage(Request $request)
    {

        $refMouvement=$request->refMouvement;
        $refMedecin=$request->refMedecin;
        $author = $request->author;
        $TypeOrientation = $request->TypeOrientation;

        //Triage====================================
        $plainte_triage=$request->plainte_triage;
        $antecedent_trige=$request->antecedent_trige;
        $cas_triage=$request->cas_triage;
        $Poids=$request->Poids;
        $Taille=$request->Taille;
        $TA=$request->TA;
        $Temperature=$request->Temperature;
        $FC=$request->FC;
        $FR=$request->FR;
        $Oxygene=$request->Oxygene;
        //Aptitude physique ============================
        // $thoracique    =  $request->thoracique;
        // $indiceDePignat    =  $request->indiceDePignat;  
        // $etatDeSante       =  $request->etatDeSante;
        // $remarque    =  $request->remarque;
        // $conclusion    =  $request->conclusion; 
        // $DateDebut       =  $request->DateDebut;
        // $DateFin    =  $request->DateFin;
        // $examination    =  $request->examination; 



        $data = tentetetriage::create([
            'refMouvement'       =>  $refMouvement,
            'dateTriage'    =>  date('Y-m-d'),                      
            'author'       =>  $author
        ]);

        $id_entete_triage_max=0;
        $enteteTriage = DB::table('tentetetriage')      
        ->selectRaw('MAX(tentetetriage.id) as code_entete_triage')
        ->where([
            ['tentetetriage.refMouvement',$refMouvement]
        ])
        ->get();
        foreach ($enteteTriage as $list) {
            $id_entete_triage_max= $list->code_entete_triage;
        }


        $data1 = tdetailtriage::create([
            'refEnteteTriage'       =>  $id_entete_triage_max,
            'plainte_triage'       =>  $plainte_triage,
            'antecedent_trige'       =>  $antecedent_trige,
            'cas_triage'       =>  $cas_triage,
            'Poids'    =>  $Poids,
            'Taille'    =>  $Taille,
            'TA'    =>  $TA,
            'Temperature'    =>  $Temperature,
            'FC'    =>  $FC,
            'FR'    => $FR,
            'Oxygene'    =>  $Oxygene,                      
            'author'       =>  $author
        ]);
        $id_detail_triage_max=0;
        $detailTriage = DB::table('tdetailtriage')      
        ->selectRaw('MAX(tdetailtriage.id) as code_detail_triage')
        ->where([
            ['tdetailtriage.refEnteteTriage',$id_entete_triage_max]
        ])
        ->get();
        foreach ($detailTriage as $list) {
            $id_detail_triage_max= $list->code_detail_triage;
        }

        $data2 = tenteteconsulter::create([
            'refDetailTriage'       =>  $id_detail_triage_max,
            'refMedecin'    =>  $refMedecin,
            'TypeOrientation'    =>  $TypeOrientation,
            'dateConsultation'    =>  date('Y-m-d'),    
            'cloture'    =>  'NON',
            'refLitUrgence'    =>  1,
            'parcours'    => 'Consultation',       
            'author'       =>  $author
        ]);
        
        $id_entete_cons_max=0;
        $enteteCons = DB::table('tenteteconsulter')      
        ->selectRaw('MAX(tenteteconsulter.id) as code_entete_cons')
        ->where([
            ['tenteteconsulter.refDetailTriage',$id_detail_triage_max]
        ])
        ->get();
        foreach ($enteteCons as $list) {
            $id_entete_cons_max= $list->code_entete_cons;
        }

        $data = DB::table('tdetailtriage')
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
        "Poids","Taille","TA","Temperature",
        'plainte_triage','antecedent_trige','cas_triage',"FC","FR","Oxygene",
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
        ->where('tdetailtriage.refEnteteTriage', $id_entete_triage_max)
        ->get();
        //
        return response()->json([
        'data' => $data,
        ]);
        // return response()->json([
        //     'data'  =>  "Patient envoyé chez le medecin avec succès!!!",
        // ]);

    }





   //'id','refEnteteTriage','plainte_triage','antecedent_trige','cas_triage','Poids','Taille','TA','Temperature','FC','FR','Oxygene','author'
    function insert_detailTriage(Request $request)
    {
       
        $data = tdetailtriage::create([
            'refEnteteTriage'       =>  $request->refEnteteTriage,
            'plainte_triage'       =>  $request->plainte_triage,
            'antecedent_trige'       =>  $request->antecedent_trige,
            'cas_triage'       =>  $request->cas_triage,
            'Poids'    =>  $request->Poids,
            'Taille'    =>  $request->Taille,
            'TA'    =>  $request->TA,
            'Temperature'    =>  $request->Temperature,
            'FC'    =>  $request->FC,
            'FR'    =>  $request->FR,
            'Oxygene'    =>  $request->Oxygene,                      
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_detailTriage(Request $request, $id)
    {
        $data = tdetailtriage::where('id', $id)->update([
            'refEnteteTriage'       =>  $request->refEnteteTriage,
            'plainte_triage'       =>  $request->plainte_triage,
            'antecedent_trige'       =>  $request->antecedent_trige,
            'cas_triage'       =>  $request->cas_triage,
            'Poids'    =>  $request->Poids,
            'Taille'    =>  $request->Taille,
            'TA'    =>  $request->TA,
            'Temperature'    =>  $request->Temperature,
            'FC'    =>  $request->FC,
            'FR'    =>  $request->FR,
            'Oxygene'    =>  $request->Oxygene,                      
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detailTriage($id)
    {
        $data = tdetailtriage::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
