<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\tim_resultat_b_c_g_ext;
use App\Traits\{GlobalMethod,Slug};

use DB;


class tim_resultatecgextController extends Controller
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

            $data = DB::table('tim_resultat_b_c_g_ext')
            ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_b_c_g_ext.refImagerie')
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
    
            ->select("tim_resultat_b_c_g_ext.id","rythme","refImagerie","rythme","ondee","segmentSt","axe",
            "ondeT","pR","oRS","indices","tim_resultat_b_c_g_ext.conclusion","medecin1","specialite1","cnom1","medecin2",
            "specialite2","cnom2","medecin3","specialite3","cnom3","medecin4","specialite4",
            "cnom4","tim_resultat_b_c_g_ext.author",
            //-------------------------------------------------------------------            
             "tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse","dateImagerie","clinique",
             "but","CNOM","examenDemande",
             "tim_imagerie_ext.specialiste" , "tim_imagerie_ext.status","medecinProtocolaire",
             'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
            //----------------------------------------------------
            "refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['status','Encours'],
                ['tim_resultat_b_c_g_ext.deleted','NON']
            ])           
            ->orderBy("tim_resultat_b_c_g_ext.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tim_resultat_b_c_g_ext')
            ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_b_c_g_ext.refImagerie')
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
    
            ->select("tim_resultat_b_c_g_ext.id","rythme","refImagerie","rythme","ondee","segmentSt","axe",
            "ondeT","pR","oRS","indices","tim_resultat_b_c_g_ext.conclusion","medecin1","specialite1","cnom1","medecin2",
            "specialite2","cnom2","medecin3","specialite3","cnom3","medecin4","specialite4",
            "cnom4","tim_resultat_b_c_g_ext.author",
            //-------------------------------------------------------------------            
             "tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse","dateImagerie","clinique",
             "but","CNOM","examenDemande",
             "tim_imagerie_ext.specialiste" , "tim_imagerie_ext.status","medecinProtocolaire",
             'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
            //----------------------------------------------------
            "refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([         
                ['status','Encours'],
                ['tim_resultat_b_c_g_ext.deleted','NON']
            ])
            ->orderBy("tim_resultat_b_c_g_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    function fetch_single_resultat_ecg($id)
    {
        $data = DB::table('tim_resultat_b_c_g_ext')
        ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_b_c_g_ext.refImagerie')
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

        ->select("tim_resultat_b_c_g_ext.id","rythme","refImagerie","rythme","ondee","segmentSt","axe",
        "ondeT","pR","oRS","indices","tim_resultat_b_c_g_ext.conclusion","medecin1","specialite1","cnom1","medecin2",
        "specialite2","cnom2","medecin3","specialite3","cnom3","medecin4","specialite4",
        "cnom4","tim_resultat_b_c_g_ext.author",
        //-------------------------------------------------------------------            
         "tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse","dateImagerie","clinique",
         "but","CNOM","examenDemande",
         "tim_imagerie_ext.specialiste" , "tim_imagerie_ext.status","medecinProtocolaire",
         'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
        //----------------------------------------------------
        "refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tim_resultat_b_c_g_ext.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    
    function fetch_result_ecg_imagerie(Request $request,$refImagerie)
    {
        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

        $data = DB::table('tim_resultat_b_c_g_ext')
        ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_b_c_g_ext.refImagerie')
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

        ->select("tim_resultat_b_c_g_ext.id","rythme","refImagerie","rythme","ondee","segmentSt","axe",
        "ondeT","pR","oRS","indices","tim_resultat_b_c_g_ext.conclusion","medecin1","specialite1","cnom1","medecin2",
        "specialite2","cnom2","medecin3","specialite3","cnom3","medecin4","specialite4",
        "cnom4","tim_resultat_b_c_g_ext.author",
        //-------------------------------------------------------------------            
         "tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse","dateImagerie","clinique",
         "but","CNOM","examenDemande",
         "tim_imagerie_ext.specialiste" , "tim_imagerie_ext.status","medecinProtocolaire",
         'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
        //----------------------------------------------------
        "refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where([
            ['noms', 'like', '%'.$query.'%'],
            ['refImagerie',$refImagerie],
            ['tim_resultat_b_c_g_ext.deleted','NON']
        ])                    
        ->orderBy("tim_resultat_b_c_g_ext.id", "desc")
        ->paginate(10);

        return response()->json([
            'data'  => $data,
        ]);
    }else{
        $data = DB::table('tim_resultat_b_c_g_ext')
        ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_b_c_g_ext.refImagerie')
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

        ->select("tim_resultat_b_c_g_ext.id","rythme","refImagerie","rythme","ondee","segmentSt","axe",
        "ondeT","pR","oRS","indices","tim_resultat_b_c_g_ext.conclusion","medecin1","specialite1","cnom1","medecin2",
        "specialite2","cnom2","medecin3","specialite3","cnom3","medecin4","specialite4",
        "cnom4","tim_resultat_b_c_g_ext.author",
        //-------------------------------------------------------------------            
         "tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse","dateImagerie","clinique",
         "but","CNOM","examenDemande",
         "tim_imagerie_ext.specialiste" , "tim_imagerie_ext.status","medecinProtocolaire",
         'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
        //----------------------------------------------------
        "refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where([
            ['refImagerie',$refImagerie],
            ['tim_resultat_b_c_g_ext.deleted','NON']
        ])  
        ->orderBy("tim_resultat_b_c_g_ext.id", "desc")
        ->paginate(10);
        return response()->json([
            'data'  => $data,
        ]);
    }
}


function insertData(Request $request)
{
   
    $data = tim_resultat_b_c_g_ext::create([
        'refImagerie'=>$request->refImagerie,
        'rythme'       =>$request->rythme,
        'ondee'     =>  $request->ondee,
        'segmentSt'         => $request->segmentSt,    
        'axe'              =>$request->axe,
        'ondeT' =>  $request->ondeT,
        'pR'      => $request->pR,  
        'oRS'             =>$request->oRS,
        'indices'             =>$request->indices,
        'conclusion'       =>  $request->conclusion,
        'medecin1'       =>  $request->medecin1,
        'specialite1'       =>  $request->specialite1,
        'cnom1'       =>  $request->cnom1,
        'medecin2'       =>  $request->medecin2,
        'specialite2'       =>  $request->specialite2,
        'cnom2'       =>  $request->cnom2,
        'medecin3'       =>  $request->medecin3,
        'specialite3'       =>  $request->specialite3,
        'cnom3'       =>  $request->cnom3,
        'medecin4'       =>  $request->medecin4,
        'specialite4'       =>  $request->specialite4,
        'cnom4'       =>  $request->cnom4,
        'author'           =>$request->author 
    ]);
    return response()->json([
        'data'  =>  "Insertion avec succès!!!",
    ]);
}


function updateData(Request $request, $id)
{
    $data = tim_resultat_b_c_g_ext::where('id', $id)->update([
        'refImagerie'=>$request->refImagerie,
        'rythme'       =>$request->rythme,
        'ondee'     =>  $request->ondee,
        'segmentSt'         => $request->segmentSt,    
        'axe'              =>$request->axe,
        'ondeT' =>  $request->ondeT,
        'pR'      => $request->pR,  
        'oRS'             =>$request->oRS,
        'indices'             =>$request->indices,
        'conclusion'       =>  $request->conclusion,
        'medecin1'       =>  $request->medecin1,
        'specialite1'       =>  $request->specialite1,
        'cnom1'       =>  $request->cnom1,
        'medecin2'       =>  $request->medecin2,
        'specialite2'       =>  $request->specialite2,
        'cnom2'       =>  $request->cnom2,
        'medecin3'       =>  $request->medecin3,
        'specialite3'       =>  $request->specialite3,
        'cnom3'       =>  $request->cnom3,
        'medecin4'       =>  $request->medecin4,
        'specialite4'       =>  $request->specialite4,
        'cnom4'       =>  $request->cnom4,
        'author'           =>$request->author 
        
    ]);
    return response()->json([
        'data'  =>  "Modification  avec succès!!!",
    ]);
}

//id,refImagerie,rythme,ondee,segmentSt,axe,ondeT,pR,oRS,indices,conclusion,medecin1,specialite1,cnom1,medecin2,
//specialite2,cnom2,medecin3,specialite3,cnom3,medecin4,specialite4,cnom4,author

 
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
     $data = tim_resultat_b_c_g_ext::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
