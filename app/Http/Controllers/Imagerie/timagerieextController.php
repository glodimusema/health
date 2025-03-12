<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\tim_imagerie_ext;
use App\Traits\{GlobalMethod,Slug};
use DB;


class timagerieextController extends Controller
{
    use GlobalMethod, Slug;
 
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    {          
     

        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tim_imagerie_ext')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tim_imagerie_ext.id","tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
             "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",'serviceProvenance','medecindemandeur',
            "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire","nomAnalyse",
            "tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse"
            ,"refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt",
            "autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune",
            "idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade",
            "etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade",
            "fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tmouvement.Statut','Encours'],
                ['tim_imagerie_ext.status','Validé'],
                ['tim_imagerie_ext.deleted','NON']
            ])           
            ->orderBy("tim_imagerie_ext.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tim_imagerie_ext')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tim_imagerie_ext.id","tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
             "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",'serviceProvenance','medecindemandeur',
            "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire","nomAnalyse",
            "tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse"
            ,"refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt",
            "autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune",
            "idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade",
            "etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade",
            "fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([                      
                ['tmouvement.Statut','Encours'],
                ['tim_imagerie_ext.status','Validé'],
                ['tim_imagerie_ext.deleted','NON']
            ])
            ->orderBy("tim_imagerie_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_finance(Request $request)
    {          
     

        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tim_imagerie_ext')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tim_imagerie_ext.id","tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
             "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",'serviceProvenance','medecindemandeur',
            "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire","nomAnalyse",
            "tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse"
            ,"refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt",
            "autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune",
            "idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade",
            "etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade",
            "fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tmouvement.Statut','Encours'],
                ['tim_imagerie_ext.deleted','NON']
            ])           
            ->orderBy("tim_imagerie_ext.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tim_imagerie_ext')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tim_imagerie_ext.id","tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
             "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",'serviceProvenance','medecindemandeur',
            "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire","nomAnalyse",
            "tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse"
            ,"refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt",
            "autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune",
            "idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade",
            "etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade",
            "fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([                      
                ['tmouvement.Statut','Encours'],
                ['tim_imagerie_ext.deleted','NON']
            ])
            ->orderBy("tim_imagerie_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }
 


    public function fetch_imagerie_mouvement(Request $request,$refMouvement)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tim_imagerie_ext')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tim_imagerie_ext.id","tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
             "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",'serviceProvenance','medecindemandeur',
            "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire","nomAnalyse",
            "tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse"
            ,"refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt",
            "autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune",
            "idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade",
            "etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade",
            "fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tmouvement.Statut','Encours'],
                ['refMouvement',$refMouvement],
                ['tim_imagerie_ext.deleted','NON']
            ])                  
            ->orderBy("tim_imagerie_ext.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tim_imagerie_ext')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tim_imagerie_ext.id","tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
             "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",'serviceProvenance','medecindemandeur',
            "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire","nomAnalyse",
            "tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse"
            ,"refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt",
            "autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune",
            "idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade",
            "etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade",
            "fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['tmouvement.Statut','Encours'],
                ['refMouvement',$refMouvement],
                ['tim_imagerie_ext.deleted','NON']
            ])    
            ->orderBy("tim_imagerie_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 


    public function fetch_imagerie_mouvement_valide(Request $request,$refMouvement)
    { 

        if (!is_null($request->get('query'))) {
            # code...refTypeCons
            $query = $this->Gquery($request);

            $data = DB::table('tim_imagerie_ext')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tim_imagerie_ext.id","tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
           "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",'serviceProvenance','medecindemandeur',
            "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire","nomAnalyse",
            "tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse"
            ,"refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt",
            "autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune",
            "idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade",
            "etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade",
            "fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tmouvement.Statut','Encours'],
                ['refMouvement',$refMouvement],
                ['tim_imagerie_ext.status','Validé'],
                ['tim_imagerie_ext.deleted','NON']
            ])                  
            ->orderBy("tim_imagerie_ext.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tim_imagerie_ext')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tim_imagerie_ext.id","tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
             "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",'serviceProvenance','medecindemandeur',
            "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire","nomAnalyse",
            "tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse"
            ,"refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt",
            "autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune",
            "idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade",
            "etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade",
            "fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['tmouvement.Statut','Encours'],
                ['refMouvement',$refMouvement],
                ['tim_imagerie_ext.status','Validé'],
                ['tim_imagerie_ext.deleted','NON']
            ])    
            ->orderBy("tim_imagerie_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 





    function fetch_single_Imagerie($id)
    {
        $data = DB::table('tim_imagerie_ext')
        ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
        ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
        ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
  
        ->select("tim_imagerie_ext.id","tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
         "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",'serviceProvenance','medecindemandeur',
        "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire","nomAnalyse",
        "tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse"
        ,"refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt",
        "autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
        "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune",
        "idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade",
        "etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade",
        "fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tim_imagerie_ext.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
//,'serviceProvenance','medecindemandeur'
 function insertData(Request $request)
 {
    $data= tim_imagerie_ext::create([
        'refMouvement' =>  $request->refMouvement,
        'refAnalyse'       => $request->refAnalyse,
        'dateImagerie'     =>   $request->dateImagerie,
        'clinique'         =>  $request->clinique,    
        'but'              => $request->but,
        'urgent'              => $request->urgent,
        'serviceProvenance'              => $request->serviceProvenance,
        'medecindemandeur'              => $request->medecindemandeur,
        'medecinProtocolaire' =>   $request->medecinProtocolaire,
        'specialiste'      =>  $request->specialiste,  
        'CNOM'             => $request->CNOM,
        'examenDemande'    =>   $request->examenDemande,                                    
        'author'           => $request->author         
     ]);
 }

 function updateData(Request $request)
 {    
    $data= tim_imagerie_ext::where('id',$request->id)->update([
       'refMouvement'=>$request->refMouvement,
       'refAnalyse'       =>$request->refAnalyse,
       'dateImagerie'     =>  $request->dateImagerie,
       'clinique'         => $request->clinique,    
       'but'              =>$request->but,
       'urgent'              =>$request->urgent,
       'serviceProvenance'              => $request->serviceProvenance,
       'medecindemandeur'              => $request->medecindemandeur,
       'medecinProtocolaire' =>  $request->medecinProtocolaire,
       'specialiste'      => $request->specialiste,  
       'CNOM'             =>$request->CNOM,
       'examenDemande'    =>  $request->examenDemande,      
       'medecinProtocolaire'    =>  $request->medecinProtocolaire,
       'specialiste'    =>  $request->specialiste,
       'CNOM'    =>  $request->CNOM,                                                       
       'author'           => $request->author       
    ]);

    return response()->json([
       'data'  =>  "Modification avec succès!!",
   ]);

 }

    function update_statuteimagerie(Request $request,$id)
    {
        $data= tim_imagerie_ext::where('id',$id)->update([
            'status'    =>  $request->status,             
            'author'       =>  $request->author     
         ]);
     
         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);       
    }
 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
     //
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
     //
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
 {
     //
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function edit($id)
 {
     //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, $id)
 {
     //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
     $data = tim_imagerie_ext::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
