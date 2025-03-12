<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\tim_resultat_f_o_g_d_ext;
use App\Traits\{GlobalMethod,Slug};
use DB;


class tim_resultat_f_o_g_d_extController extends Controller
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

            $data = DB::table('tim_resultat_f_o_g_d_ext')
            ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_f_o_g_d_ext.refImagerie')
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
    
            ->select("tim_resultat_f_o_g_d_ext.id","dateResultat","oesophase","cardia","lacmugueux",
            "fundus","autres","pylore","bulbe","deuxiemeDuo","biopseis",
            "tim_resultat_f_o_g_d_ext.conclusion","photo_resultat","tim_resultat_f_o_g_d_ext.author",
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
                ['tim_resultat_f_o_g_d_ext.deleted','NON']
            ])           
            ->orderBy("tim_resultat_f_o_g_d_ext.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tim_resultat_f_o_g_d_ext')
            ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_f_o_g_d_ext.refImagerie')
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
    
            ->select("tim_resultat_f_o_g_d_ext.id","dateResultat","oesophase","cardia","lacmugueux",
            "fundus","autres","pylore","bulbe","deuxiemeDuo","biopseis",
            "tim_resultat_f_o_g_d_ext.conclusion","photo_resultat","tim_resultat_f_o_g_d_ext.author",
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
                ['tim_resultat_f_o_g_d_ext.deleted','NON']
            ])
            ->orderBy("tim_resultat_f_o_g_d_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    function fetch_single_Resultat($id)
    {
        $data = DB::table('tim_resultat_f_o_g_d_ext')
        ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_f_o_g_d_ext.refImagerie')
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

        ->select("tim_resultat_f_o_g_d_ext.id","dateResultat","oesophase","cardia","lacmugueux",
        "fundus","autres","pylore","bulbe","deuxiemeDuo","biopseis",
        "tim_resultat_f_o_g_d_ext.conclusion","photo_resultat","tim_resultat_f_o_g_d_ext.author",
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
        ->where('tim_resultat_f_o_g_d_ext.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    
    function fetch_result_imagerie(Request $request,$refImagerie)
    {
        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

        $data = DB::table('tim_resultat_f_o_g_d_ext')
        ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_f_o_g_d_ext.refImagerie')
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

        ->select("tim_resultat_f_o_g_d_ext.id","dateResultat","oesophase","cardia","lacmugueux",
        "fundus","autres","pylore","bulbe","deuxiemeDuo","biopseis",
        "tim_resultat_f_o_g_d_ext.conclusion","photo_resultat","tim_resultat_f_o_g_d_ext.author",
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
            ['tim_resultat_f_o_g_d_ext.deleted','NON']
        ])                    
        ->orderBy("tim_resultat_f_o_g_d_ext.id", "desc")
        ->paginate(10);

        return response()->json([
            'data'  => $data,
        ]);
    }else{
        $data = DB::table('tim_resultat_f_o_g_d_ext')
        ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_f_o_g_d_ext.refImagerie')
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

        ->select("tim_resultat_f_o_g_d_ext.id","dateResultat","oesophase","cardia","lacmugueux",
        "fundus","autres","pylore","bulbe","deuxiemeDuo","biopseis",
        "tim_resultat_f_o_g_d_ext.conclusion","photo_resultat","tim_resultat_f_o_g_d_ext.author",
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
            ['tim_resultat_f_o_g_d_ext.deleted','NON']
        ])    
        ->orderBy("tim_resultat_f_o_g_d_ext.id", "desc")
        ->paginate(10);
        return response()->json([
            'data'  => $data,
        ]);
    }
}


//id,refImagerie,dateResultat,oesophase,cardia,lacmugueux,fundus,autres,pylore,bulbe,deuxiemeDuo,biopseis,conclusion,photo_resultat,author
function insertData(Request $request)
 {

     if (!is_null($request->image)) 
     {
        $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();          
         $request->image->move(public_path('/fichier'), $imageName); 

         $data= tim_resultat_f_o_g_d_ext::create([
            'refImagerie'=>$formData->refImagerie,
            'dateResultat'       =>$formData->dateResultat,
            'oesophase'     =>  $formData->oesophase,
            'cardia'         => $formData->cardia,    
            'lacmugueux'              =>$formData->lacmugueux,
            'fundus' =>  $formData->fundus,
            'autres'      => $formData->autres,  
            'pylore'             =>$formData->pylore,
            'bulbe'    =>  $formData->bulbe,
            'deuxiemeDuo'        => $formData->deuxiemeDuo,  
            'biopseis'      =>$formData->biopseis,
            'conclusion'       =>  $formData->conclusion,
            'photo_resultat'            =>  $imageName,
            'author'           =>$formData->author        
         ]);

         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
     }
     else{
        $formData = json_decode($_POST['data']);
        $data= tim_resultat_f_o_g_d_ext::create([
            'refImagerie'=>$formData->refImagerie,
            'dateResultat'       =>$formData->dateResultat,
            'oesophase'     =>  $formData->oesophase,
            'cardia'         => $formData->cardia,    
            'lacmugueux'              =>$formData->lacmugueux,
            'fundus' =>  $formData->fundus,
            'autres'      => $formData->autres,  
            'pylore'             =>$formData->pylore,
            'bulbe'    =>  $formData->bulbe,
            'deuxiemeDuo'        => $formData->deuxiemeDuo,  
            'biopseis'      =>$formData->biopseis,
            'conclusion'       =>  $formData->conclusion,
            'photo_resultat'            =>  'avatar.png',
            'author'           =>$formData->author        
         ]);
         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

     }

 }

 function updateData(Request $request)
 {

     if (!is_null($request->image)) 
     {
         $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();          
         $request->image->move(public_path('/fichier'), $imageName);
      
        $data= tim_resultat_f_o_g_d_ext::where('id',$formData->id)->update([
            'refImagerie'=>$formData->refImagerie,
            'dateResultat'       =>$formData->dateResultat,
            'oesophase'     =>  $formData->oesophase,
            'cardia'         => $formData->cardia,    
            'lacmugueux'              =>$formData->lacmugueux,
            'fundus' =>  $formData->fundus,
            'autres'      => $formData->autres,  
            'pylore'             =>$formData->pylore,
            'bulbe'    =>  $formData->bulbe,
            'deuxiemeDuo'        => $formData->deuxiemeDuo,  
            'biopseis'      =>$formData->biopseis,
            'conclusion'       =>  $formData->conclusion,
            'photo_resultat'            =>  $imageName,
            'author'           =>$formData->author 
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);
 
     }
     else{
         $formData = json_decode($_POST['data']);
         $data= tim_resultat_f_o_g_d_ext::where('id',$formData->id)->update([
            'refImagerie'=>$formData->refImagerie,
            'dateResultat'       =>$formData->dateResultat,
            'oesophase'     =>  $formData->oesophase,
            'cardia'         => $formData->cardia,    
            'lacmugueux'              =>$formData->lacmugueux,
            'fundus' =>  $formData->fundus,
            'autres'      => $formData->autres,  
            'pylore'             =>$formData->pylore,
            'bulbe'    =>  $formData->bulbe,
            'deuxiemeDuo'        => $formData->deuxiemeDuo,  
            'biopseis'      =>$formData->biopseis,
            'conclusion'       =>  $formData->conclusion,
            'photo_resultat'            =>  'avatar.png',
            'author'           =>$formData->author       
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);

     }

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
     $data = tim_resultat_f_o_g_d_ext::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
