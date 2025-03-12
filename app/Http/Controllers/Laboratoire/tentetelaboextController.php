<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratoire\tentetelabo_ext;
use DB;

class tentetelaboextController extends Controller
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

            $data = DB::table('tentetelabo_ext')
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
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tentetelabo_ext.id","refMouvement",'statutentetelaboext',"tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin","serviceProvenance",
            "nompreleveur", "dateprelevement","tentetelabo_ext.author","tentetelabo_ext.created_at",
            "tentetelabo_ext.updated_at","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo_ext.observation as observation2","tdetaillabo_ext.libelle as resultat2","tdetaillabo_ext.natureechantillon as natureechantillon2",
            "tdetaillabo_ext.methode as methode2","tdetaillabo_ext.commentaire as commentaire2",
            "tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tentetelabo_ext.deleted','NON']
            ])           
            ->orderBy("tentetelabo_ext.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tentetelabo_ext')
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
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tentetelabo_ext.id","refMouvement",'statutentetelaboext',"tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin","serviceProvenance",
            "nompreleveur", "dateprelevement","tentetelabo_ext.author","tentetelabo_ext.created_at",
            "tentetelabo_ext.updated_at","refMalade","refTypeMouvement","dateMouvement","numroBon","serviceProvenance",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo_ext.observation as observation2","tdetaillabo_ext.libelle as resultat2","tdetaillabo_ext.natureechantillon as natureechantillon2",
            "tdetaillabo_ext.methode as methode2","tdetaillabo_ext.commentaire as commentaire2",
            "tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([         
                ['tentetelabo_ext.deleted','NON']
            ]) 
            ->orderBy("tentetelabo_ext.id", "desc")
            ->paginate(10);
                return response()->json([
                        'data'  => $data,
                ]);
            }

    }


    


    public function fetch_entete_labo(Request $request,$refMouvement)
    { 
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tentetelabo_ext')
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
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tentetelabo_ext.id","refMouvement",'statutentetelaboext',"tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin","serviceProvenance",
            "nompreleveur", "dateprelevement","tentetelabo_ext.author","tentetelabo_ext.created_at",
            "tentetelabo_ext.updated_at","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","serviceProvenance",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo_ext.observation as observation2","tdetaillabo_ext.libelle as resultat2","tdetaillabo_ext.natureechantillon as natureechantillon2",
            "tdetaillabo_ext.methode as methode2","tdetaillabo_ext.commentaire as commentaire2",
            "tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refMouvement',$refMouvement],
                ['statutentetelaboext','Validé'],          
                ['tentetelabo_ext.deleted','NON']
            ])                     
            ->orderBy("tentetelabo_ext.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tentetelabo_ext')
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
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tentetelabo_ext.id","refMouvement",'statutentetelaboext',"tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin","serviceProvenance",
            "nompreleveur", "dateprelevement","tentetelabo_ext.author","tentetelabo_ext.created_at",
            "tentetelabo_ext.updated_at","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","serviceProvenance",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo_ext.observation as observation2","tdetaillabo_ext.libelle as resultat2","tdetaillabo_ext.natureechantillon as natureechantillon2",
            "tdetaillabo_ext.methode as methode2","tdetaillabo_ext.commentaire as commentaire2",
            "tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['refMouvement',$refMouvement],
                ['statutentetelaboext','Validé'],          
                ['tentetelabo_ext.deleted','NON']
            ])     
            ->orderBy("tentetelabo_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    public function fetch_entete_labo_attente(Request $request,$refMouvement)
    { 
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tentetelabo_ext')
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
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tentetelabo_ext.id","refMouvement",'statutentetelaboext',"tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin","serviceProvenance",
            "nompreleveur", "dateprelevement","tentetelabo_ext.author","tentetelabo_ext.created_at",
            "tentetelabo_ext.updated_at","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","serviceProvenance",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo_ext.observation as observation2","tdetaillabo_ext.libelle as resultat2","tdetaillabo_ext.natureechantillon as natureechantillon2",
            "tdetaillabo_ext.methode as methode2","tdetaillabo_ext.commentaire as commentaire2",
            "tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refMouvement',$refMouvement],
                ['statutentetelaboext','Attente'],          
                ['tentetelabo_ext.deleted','NON']
            ])                     
            ->orderBy("tentetelabo_ext.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tentetelabo_ext')
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
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tentetelabo_ext.id","refMouvement",'statutentetelaboext',"tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin","serviceProvenance",
            "nompreleveur", "dateprelevement","tentetelabo_ext.author","tentetelabo_ext.created_at",
            "tentetelabo_ext.updated_at","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","serviceProvenance",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo_ext.observation as observation2","tdetaillabo_ext.libelle as resultat2","tdetaillabo_ext.natureechantillon as natureechantillon2",
            "tdetaillabo_ext.methode as methode2","tdetaillabo_ext.commentaire as commentaire2",
            "tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['refMouvement',$refMouvement],
                ['statutentetelaboext','Attente'],          
                ['tentetelabo_ext.deleted','NON']
            ])     
            ->orderBy("tentetelabo_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    


    //mes scripts
    function fetch_list_ValeurForExam($refExamen)
    {
        $data = DB::table('tvaleurnormale')
        ->select("tvaleurnormale.id","tvaleurnormale.designation")
        ->Where('refExamen',$refExamen) 
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_ExamenForCat($refCatexamen)
    {
        $data = DB::table('texamen')
        ->select("texamen.id","texamen.designation")
        ->Where('refCatexamen',$refCatexamen) 
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_CatexamenForGrandCat($refGrandCategorie)
    {
        $data = DB::table('tcategorieexament')
        ->select("tcategorieexament.id","tcategorieexament.designation")
        ->Where('refGrandCategorie',$refGrandCategorie) 
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_GrandCategorie()
    {
        $data = DB::table('tgcategorieexament')
        ->select("tgcategorieexament.id","tgcategorieexament.designation")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_entete($id)
    {

        $data = DB::table('tentetelabo_ext')
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
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tentetelabo_ext.id","refMouvement",'statutentetelaboext',"tentetelabo_ext.refExamen","dateLabo"
        ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin","serviceProvenance",
        "nompreleveur", "dateprelevement","tentetelabo_ext.author","tentetelabo_ext.created_at",
        "tentetelabo_ext.updated_at","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","serviceProvenance",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade","texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
        "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
        "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale2",
        "tdetaillabo_ext.observation as observation2","tdetaillabo_ext.libelle as resultat2","tdetaillabo_ext.natureechantillon as natureechantillon2",
        "tdetaillabo_ext.methode as methode2","tdetaillabo_ext.commentaire as commentaire2",
        "tvaleurnormale.unite as unite2")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tentetelabo_ext.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }
    // 'serviceProvenance'    =>  $request->serviceProvenance,
   //'refMouvement','refExamen','dateLabo','author',nommedecin,nomcentremedical, adressecentre, telephonemedecin, mailmedecin, nompreleveur, dateprelevement
    function insert_entete(Request $request)
    {
       
        $data = tentetelabo_ext::create([
            'refMouvement'       =>  $request->refMouvement,
            'refExamen'    =>  $request->refExamen,
            'dateLabo'    =>  date('Y-m-d'),                   
            'author'       =>  $request->author,                   
            'nommedecin'       =>  $request->nommedecin,                   
            'nomcentremedical'       =>  $request->nomcentremedical,                   
            'adressecentre'       =>  $request->adressecentre,                   
            'telephonemedecin'       =>  $request->telephonemedecin,                   
            'mailmedecin'       =>  $request->mailmedecin,                   
            'nompreleveur'       =>  $request->nompreleveur,                   
            'dateprelevement'       =>  $request->dateprelevement,
            'serviceProvenance'    =>  $request->serviceProvenance,
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

//statutentetelaboext
    function update_entete(Request $request, $id)
    {
        $data = tentetelabo_ext::where('id', $id)->update([
            'refMouvement'       =>  $request->refMouvement,
            'refExamen'    =>  $request->refExamen,
            // 'dateLabo'    =>  $request->dateLabo,                   
            'author'       =>  $request->author,                   
            'nommedecin'       =>  $request->nommedecin,                   
            'nomcentremedical'       =>  $request->nomcentremedical,                   
            'adressecentre'       =>  $request->adressecentre,                   
            'telephonemedecin'       =>  $request->telephonemedecin,                   
            'mailmedecin'       =>  $request->mailmedecin,                   
            'nompreleveur'       =>  $request->nompreleveur,                   
            'dateprelevement'       =>  $request->dateprelevement,
            'serviceProvenance'    =>  $request->serviceProvenance,
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
//
    function update_statutexamenext(Request $request, $id)
    {
        $data = tentetelabo_ext::where('id', $id)->update([
            'statutentetelaboext'    =>  $request->statutentetelaboext,                   
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_entete($id)
    {
        $data = tentetelabo_ext::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
