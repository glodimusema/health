<?php

namespace App\Http\Controllers\Consultations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultations\tpatient_annexes;
use App\Traits\{GlobalMethod,Slug};
use Illuminate\Support\Facades\Storage;
use DB;
use File;
use Response;

class tpatient_annexesController extends Controller
{


    use GlobalMethod, Slug;

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
        
    //    $table->integer('refPatient');
         //   $table->string('pdfPatient',100);
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tpatient_annexes')
            ->join('tclient','tclient.id','=','tpatient_annexes.refPatient')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tpatient_annexes.id",'refPatient',"pdfPatient","desicriptionPDF",
            "tpatient_annexes.created_at","tpatient_annexes.updated_at","tpatient_annexes.author",
            "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille",
            "nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tpatient_annexes.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data' => $data,
                ]);
           

        }
        else{
            $data = DB::table('tpatient_annexes')
            ->join('tclient','tclient.id','=','tpatient_annexes.refPatient')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tpatient_annexes.id",'refPatient',"pdfPatient","desicriptionPDF",
            "tpatient_annexes.created_at","tpatient_annexes.updated_at","tpatient_annexes.author",
            "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille",
            "nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->orderBy("tpatient_annexes.id", "desc")
            ->paginate(10);
            return response()->json([
                'data' => $data,
                ]);
            }

    }


    public function fetch_annexe_patient(Request $request,$refPatient)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tpatient_annexes')
            ->join('tclient','tclient.id','=','tpatient_annexes.refPatient')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tpatient_annexes.id",'refPatient',"pdfPatient","desicriptionPDF",
            "tpatient_annexes.created_at","tpatient_annexes.updated_at","tpatient_annexes.author",
            "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille",
            "nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refPatient',$refPatient]
            ])                    
            ->orderBy("tpatient_annexes.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tpatient_annexes')
            ->join('tclient','tclient.id','=','tpatient_annexes.refPatient')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tpatient_annexes.id",'refPatient',"pdfPatient","desicriptionPDF",
            "tpatient_annexes.created_at","tpatient_annexes.updated_at","tpatient_annexes.author",
            "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille",
            "nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where('refPatient',$refPatient)    
            ->orderBy("tpatient_annexes.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    function fetch_single_annexe_patient($id)
    {

        $data = DB::table('tpatient_annexes')
        ->join('tclient','tclient.id','=','tpatient_annexes.refPatient')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
  
        ->select("tpatient_annexes.id",'refPatient',"pdfPatient","desicriptionPDF",
        "tpatient_annexes.created_at","tpatient_annexes.updated_at","tpatient_annexes.author",
        "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
        "tclient.photo","tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille",
        "nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tpatient_annexes.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }


function insertData(Request $request)
 {
    
     if (!is_null($request->image)) 
     {
        $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();          
         $request->image->move(public_path('/fichier'), $imageName); 

         $data= tpatient_annexes::create([
            'refPatient'=>$formData->refPatient,
            'pdfPatient'=>$imageName,
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author          
         ]);

         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
     }
     else{
        $formData = json_decode($_POST['data']);
        $data= tpatient_annexes::create([
            'refPatient'=>$formData->refPatient,
            'pdfPatient'=>'avatar.png',
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author        
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
      
        $data= tpatient_annexes::where('id',$formData->id)->update([
            'refPatient'=>$formData->refPatient,
            'pdfPatient'=>$imageName,
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author    
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);
 
     }
     else{
         $formData = json_decode($_POST['data']);
         $data= tpatient_annexes::where('id',$formData->id)->update([
            'refPatient'=>$formData->refPatient,
            'pdfPatient'=>'avatar.png',
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author       
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);
 

     }

 }

 public function downloadfile($filenamess)
 {
     $filepath = public_path('fichier/'.$filenamess.'');
     return response()->file($filepath);
 }


    function delete_annexe($id)
    {
        $data = tpatient_annexes::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "SUppression avec succès!!",
        ]);

        
    }
//

   





}
