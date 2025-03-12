<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\tenfant_archivage;
use App\Traits\{GlobalMethod,Slug};
use Illuminate\Support\Facades\Storage;
use DB;
use File;
use Response;

class tEnfantArchivageController extends Controller
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
        
    //    $table->integer('refImagerie');
         //   $table->string('pdfImagerie',100);
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tenfant_archivage') 
            ->select("tenfant_archivage.id","pdfImagerie","desicriptionPDF","tenfant_archivage.author")
            ->where('desicriptionPDF', 'like', '%'.$query.'%')            
            ->orderBy("tenfant_archivage.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data' => $data,
                ]);
           

        }
        else{
            $data = DB::table('tenfant_archivage') 
            ->select("tenfant_archivage.id","pdfImagerie","desicriptionPDF","tenfant_archivage.author")
            ->orderBy("tenfant_archivage.id", "desc")
            ->paginate(10);
            return response()->json([
                'data' => $data,
                ]);
            }

    }



    function fetch_single_archivage($id)
    {

        $data = DB::table('tenfant_archivage') 
        ->select("tenfant_archivage.id","pdfImagerie","desicriptionPDF","tenfant_archivage.author")
        ->where('tenfant_archivage.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }


function insertData(Request $request)
 {
    ////id,refImagerie,pdfImagerie,desicriptionPDF,author

     if (!is_null($request->image)) 
     {
        $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();          
         $request->image->move(public_path('/fichier'), $imageName); 

         $data= tenfant_archivage::create([
            'pdfImagerie'=>$imageName,
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author          
         ]);

         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
     }
     else{
        $formData = json_decode($_POST['data']);
        $data= tenfant_archivage::create([
            'pdfImagerie'=>'avatar.png',
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
      
        $data= tenfant_archivage::where('id',$formData->id)->update([
            'pdfImagerie'=>$imageName,
            'desicriptionPDF'=>$formData->desicriptionPDF,
            'author'=>$formData->author    
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);
 
     }
     else{
         $formData = json_decode($_POST['data']);
         $data= tenfant_archivage::where('id',$formData->id)->update([            
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
        $data = tenfant_archivage::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "SUppression avec succès!!",
        ]);

        
    }
//

   





}
