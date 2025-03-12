<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratoire\tdetaillabo_ext;
use DB;

class tdetaillaboextController extends Controller
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

            $data = DB::table('tdetaillabo_ext')
            ->join('tentetelabo_ext','tentetelabo_ext.id','=','tdetaillabo_ext.refEnteteLabo')
            ->join('texamen','texamen.id','=','tentetelabo_ext.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo_ext.refValeur')
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
            ->select("tdetaillabo_ext.id","refEnteteLabo","refValeur","libelle","observation",
            "tdetaillabo_ext.author","tdetaillabo_ext.created_at",
            "tdetaillabo_ext.updated_at","refMouvement","tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin",
            "nompreleveur", "dateprelevement","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale",
            "tdetaillabo_ext.natureechantillon as natureechantillon",
            "tdetaillabo_ext.methode as methode","tdetaillabo_ext.commentaire as commentaire","tvaleurnormale.unite as
            unite")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tdetaillabo_ext.deleted','NON']
            ])            
            ->orderBy("tdetaillabo_ext.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tdetaillabo_ext')
            ->join('tentetelabo_ext','tentetelabo_ext.id','=','tdetaillabo_ext.refEnteteLabo')
            ->join('texamen','texamen.id','=','tentetelabo_ext.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo_ext.refValeur')
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
            ->select("tdetaillabo_ext.id","refEnteteLabo","refValeur","libelle","observation",
            "tdetaillabo_ext.author","tdetaillabo_ext.created_at",
            "tdetaillabo_ext.updated_at","refMouvement","tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin",
            "nompreleveur", "dateprelevement","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade"
            ,"texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale",
            "tdetaillabo_ext.natureechantillon as natureechantillon",
            "tdetaillabo_ext.methode as methode","tdetaillabo_ext.commentaire as commentaire","tvaleurnormale.unite as
            unite")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([          
                ['tdetaillabo_ext.deleted','NON']
            ])
            ->orderBy("tdetaillabo_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_detail_for_entete(Request $request,$refEntete)
    {  
        
          
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdetaillabo_ext')
            ->join('tentetelabo_ext','tentetelabo_ext.id','=','tdetaillabo_ext.refEnteteLabo')
            ->join('texamen','texamen.id','=','tentetelabo_ext.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo_ext.refValeur')
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
            ->select("tdetaillabo_ext.id","refEnteteLabo","refValeur","libelle","observation",
            "tdetaillabo_ext.author","tdetaillabo_ext.created_at",
            "tdetaillabo_ext.updated_at","refMouvement","tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin",
            "nompreleveur", "dateprelevement","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade"
            ,"texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale",
            "tdetaillabo_ext.natureechantillon as natureechantillon",
            "tdetaillabo_ext.methode as methode","tdetaillabo_ext.commentaire as commentaire",
            "tvaleurnormale.unite as unite")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEnteteLabo',$refEntete],          
                ['tdetaillabo_ext.deleted','NON']
            ])                     
            ->orderBy("tdetaillabo_ext.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tdetaillabo_ext')
            ->join('tentetelabo_ext','tentetelabo_ext.id','=','tdetaillabo_ext.refEnteteLabo')
            ->join('texamen','texamen.id','=','tentetelabo_ext.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo_ext.refValeur')
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
            ->select("tdetaillabo_ext.id","refEnteteLabo","refValeur","libelle","observation",
            "tdetaillabo_ext.author","tdetaillabo_ext.created_at",
            "tdetaillabo_ext.updated_at","refMouvement","tentetelabo_ext.refExamen","dateLabo"
            ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin",
            "nompreleveur", "dateprelevement","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale",
            "tdetaillabo_ext.natureechantillon as natureechantillon",
            "tdetaillabo_ext.methode as methode","tdetaillabo_ext.commentaire as commentaire",
            "tvaleurnormale.unite as unite")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['refEnteteLabo',$refEntete],          
                ['tdetaillabo_ext.deleted','NON']
            ])
            ->orderBy("tdetaillabo_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    
    

    function fetch_single_detail($id)
    {
        $data = DB::table('tdetaillabo_ext')
        ->join('tentetelabo_ext','tentetelabo_ext.id','=','tdetaillabo_ext.refEnteteLabo')
        ->join('texamen','texamen.id','=','tentetelabo_ext.refExamen')
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo_ext.refValeur')
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
        ->select("tdetaillabo_ext.id","refEnteteLabo","refValeur","libelle","observation",
        "tdetaillabo_ext.author","tdetaillabo_ext.created_at",
        "tdetaillabo_ext.updated_at","refMouvement","tentetelabo_ext.refExamen","dateLabo"
        ,"nommedecin","nomcentremedical", "adressecentre","telephonemedecin", "mailmedecin",
        "nompreleveur", "dateprelevement","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade"
        ,"texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
        "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
        "codeTube","designationTube","couleurTube","tvaleurnormale.designation as ValeurNormale",
        "tdetaillabo_ext.natureechantillon as natureechantillon",
        "tdetaillabo_ext.methode as methode","tdetaillabo_ext.commentaire as commentaire","tvaleurnormale.unite as
        unite")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tdetaillabo_ext.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'refEnteteLabo','refValeur','libelle','observation','author
    function insert_detail(Request $request)
    {       
        $data = tdetaillabo_ext::create([
            'refEnteteLabo'       =>  $request->refEnteteLabo,
            'refValeur'    =>  $request->refValeur,
            'libelle'    =>  $request->libelle,
            'observation'    =>  $request->observation,
            'natureechantillon'    =>  $request->natureechantillon,
            'methode'    =>  $request->methode,
            'commentaire'    =>  $request->commentaire,                     
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_detail(Request $request, $id)
    {
        $data = tdetaillabo_ext::where('id', $id)->update([
            'refEnteteLabo'       =>  $request->refEnteteLabo,
            'refValeur'    =>  $request->refValeur,
            'libelle'    =>  $request->libelle,
            'observation'    =>  $request->observation,
            'natureechantillon'    =>  $request->natureechantillon,
            'methode'    =>  $request->methode,
            'commentaire'    =>  $request->commentaire,                     
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tdetaillabo_ext::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
