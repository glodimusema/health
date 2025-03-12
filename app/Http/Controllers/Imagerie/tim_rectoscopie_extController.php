<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\tim_rectoscopie_ext;
use App\Traits\{GlobalMethod,Slug};

use DB;


class tim_rectoscopie_extController extends Controller
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



            
            $data = DB::table('tim_rectoscopie_ext')
            ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_rectoscopie_ext.refImagerie')
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
    
            ->select("tim_rectoscopie_ext.id","image_rectoscopie","inspection","toucherRectal",
            "anuscopie","rectoscopie","conclusion_recto","tim_rectoscopie_ext.author",
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
                ['tim_rectoscopie_ext.deleted','NON']
            ])           
            ->orderBy("tim_rectoscopie_ext.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
                  
            $data = DB::table('tim_rectoscopie_ext')
            ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_rectoscopie_ext.refImagerie')
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
    
            ->select("tim_rectoscopie_ext.id","image_rectoscopie","inspection","toucherRectal",
            "anuscopie","rectoscopie","conclusion_recto","tim_rectoscopie_ext.author",
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
                ['tim_rectoscopie_ext.deleted','NON']
            ])
            ->orderBy("tim_rectoscopie_ext.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    function fetch_single($id)
    {
            
        $data = DB::table('tim_rectoscopie_ext')
        ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_rectoscopie_ext.refImagerie')
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

        ->select("tim_rectoscopie_ext.id","image_rectoscopie","inspection","toucherRectal",
        "anuscopie","rectoscopie","conclusion_recto","tim_rectoscopie_ext.author",
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
        ->where('tim_rectoscopie_ext.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_rectoscopie_imagerie(Request $request,$refImagerie)
    {
        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

                  
            $data = DB::table('tim_rectoscopie_ext')
            ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_rectoscopie_ext.refImagerie')
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
    
            ->select("tim_rectoscopie_ext.id","image_rectoscopie","inspection","toucherRectal",
            "anuscopie","rectoscopie","conclusion_recto","tim_rectoscopie_ext.author",
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
                ['tim_rectoscopie_ext.deleted','NON']
            ])                    
            ->orderBy("tim_rectoscopie_ext.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
    }else{
                    
        $data = DB::table('tim_rectoscopie_ext')
        ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_rectoscopie_ext.refImagerie')
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

        ->select("tim_rectoscopie_ext.id","image_rectoscopie","inspection","toucherRectal",
        "anuscopie","rectoscopie","conclusion_recto","tim_rectoscopie_ext.author",
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
            ['tim_rectoscopie_ext.deleted','NON']
        ])    
        ->orderBy("tim_rectoscopie_ext.id", "desc")
        ->paginate(10);
        return response()->json([
            'data'  => $data,
        ]);
    }
}

// refImagerie,inspection,toucherRectal,anuscopie,image_rectoscopie,conclusion_recto,author

function insertData(Request $request)
 {

     if (!is_null($request->image)) 
     {
        $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();          
         $request->image->move(public_path('/fichier'), $imageName); 

         $data= tim_rectoscopie_ext::create([
            'refImagerie'=>$formData->refImagerie,
            'inspection'       =>$formData->inspection,
            'toucherRectal'     =>  $formData->toucherRectal,
            'anuscopie'         => $formData->anuscopie,    
            'rectoscopie'         => $formData->rectoscopie,    
            'image_rectoscopie'            =>  $imageName,
            'conclusion_recto'         => $formData->conclusion_recto,  
            'author'           =>$formData->author        
         ]);

         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
     }
     else{
        $formData = json_decode($_POST['data']);
        $data= tim_rectoscopie_ext::create([
            'refImagerie'=>$formData->refImagerie,
            'inspection'       =>$formData->inspection,
            'toucherRectal'     =>  $formData->toucherRectal,
            'anuscopie'         => $formData->anuscopie,    
            'rectoscopie'         => $formData->rectoscopie,    
            'image_rectoscopie'            =>  'avatar.png',
            'conclusion_recto'         => $formData->conclusion_recto,
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
      
        $data= tim_rectoscopie_ext::where('id',$formData->id)->update([
            'refImagerie'=>$request->refImagerie,
            'inspection'       =>$formData->inspection,
            'toucherRectal'     =>  $formData->toucherRectal,
            'anuscopie'         => $formData->anuscopie,    
            'rectoscopie'         => $formData->rectoscopie,    
            'image_rectoscopie'            =>  $imageName,
            'conclusion_recto'         => $formData->conclusion_recto,
            'author'           =>$formData->author 
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);
 
     }
     else{
         $formData = json_decode($_POST['data']);
         $data= tim_rectoscopie_ext::where('id',$formData->id)->update([
            'refImagerie'=>$formData->refImagerie,
            'inspection'       =>$formData->inspection,
            'toucherRectal'     =>  $formData->toucherRectal,
            'anuscopie'         => $formData->anuscopie,    
            'rectoscopie'         => $formData->rectoscopie,    
            'image_rectoscopie'            =>  'avatar.png',
            'conclusion_recto'         => $formData->conclusion_recto,
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
     $data = tim_rectoscopie_ext::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
