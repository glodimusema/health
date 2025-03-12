<?php

namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacie\tmed_entetebesoin;
use DB;

class tmed_entetebesoinController extends Controller
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
        //tmed_entetebesoin id,refService,refMouvement,refSalle,date_besoin,author
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tmed_entetebesoin')
            ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
            ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
            ->select("tmed_entetebesoin.id","refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_besoin","tmed_entetebesoin.author","tmed_entetebesoin.created_at",
            "tmed_entetebesoin.updated_at","refMalade","refTypeMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"dateMouvement","numroBon","Statut",
            "dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement",
            "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo",
            "slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tmed_entetebesoin.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmed_entetebesoin')
            ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
            ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
            ->select("tmed_entetebesoin.id","refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_besoin","tmed_entetebesoin.author","tmed_entetebesoin.created_at",
            "tmed_entetebesoin.updated_at","refMalade","refTypeMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"dateMouvement","numroBon","Statut",
            "dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement",
            "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo",
            "slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->orderBy("tmed_entetebesoin.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_entete_mouvement(Request $request,$refMouvement)
    { 
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tmed_entetebesoin')
            ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
            ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
            ->select("tmed_entetebesoin.id","refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_besoin","tmed_entetebesoin.author","tmed_entetebesoin.created_at",
            "tmed_entetebesoin.updated_at","refMalade","refTypeMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"dateMouvement","numroBon","Statut",
            "dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement",
            "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo",
            "slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['refMouvement',$refMouvement]
            ])             
            ->orderBy("tmed_entetebesoin.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tmed_entetebesoin')
            ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
            ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
            ->select("tmed_entetebesoin.id","refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_besoin","tmed_entetebesoin.author","tmed_entetebesoin.created_at",
            "tmed_entetebesoin.updated_at","refMalade","refTypeMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"dateMouvement","numroBon","Statut",
            "dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement",
            "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo",
            "slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where('refMouvement',$refMouvement) 
            ->orderBy("tmed_entetebesoin.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    

    function fetch_single_entete($id)
    {
        $data = DB::table('tmed_entetebesoin')
        ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
        ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
        ->select("tmed_entetebesoin.id","refMouvement","refService","refSalle","nom_service",'nom_salle',
        'PrixSalle',"date_besoin","tmed_entetebesoin.author","tmed_entetebesoin.created_at",
        "tmed_entetebesoin.updated_at","refMalade","refTypeMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"dateMouvement","numroBon","Statut",
        "dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement",
        "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo",
        "slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
        "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade","dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tmed_entetebesoin.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //tmed_entetebesoin id,refService,refMouvement,refSalle,date_besoin,author
    function insert_entete(Request $request)
    {
       
        $data = tmed_entetebesoin::create([
            'refService'       =>  $request->refService,
            'refMouvement'       =>  $request->refMouvement,
            'refSalle'       =>  $request->refSalle,
            'date_besoin'    =>  $request->date_besoin,           
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_entete(Request $request, $id)
    {
        $data = tmed_entetebesoin::where('id', $id)->update([
            'refService'       =>  $request->refService,
            'refMouvement'       =>  $request->refMouvement,
            'refSalle'       =>  $request->refSalle,
            'date_besoin'    =>  $request->date_besoin,           
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_entete($id)
    {
        $data = tmed_entetebesoin::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
