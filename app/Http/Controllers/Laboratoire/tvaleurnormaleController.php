<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Laboratoire\{tvaleurnormale};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tvaleurnormaleController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);


            $data = DB::table('tvaleurnormale')
            ->join('texamen','texamen.id','=','tvaleurnormale.refExamen')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->select("tvaleurnormale.id","tvaleurnormale.designation","refExamen","detailValeur","tvaleurnormale.created_at",
            "tvaleurnormale.updated_at","texamen.designation as Examen","refCatexamen","tcategorieexament.designation as designationCat","refGrandCategorie",
            "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube","designationTube","couleurTube","detailValeur","unite")
            ->where('tvaleurnormale.designation', 'like', '%'.$query.'%')
            ->orWhere('texamen.designation', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tvaleurnormale')
            ->join('texamen','texamen.id','=','tvaleurnormale.refExamen')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->select("tvaleurnormale.id","tvaleurnormale.designation","refExamen","detailValeur","tvaleurnormale.created_at",
            "tvaleurnormale.updated_at","texamen.designation as Examen","refCatexamen","tcategorieexament.designation as designationCat","refGrandCategorie",
            "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube","designationTube","couleurTube","detailValeur","unite")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tvaleurnormale_2()
    {
        $data = DB::table('tvaleurnormale')
        ->join('texamen','texamen.id','=','tvaleurnormale.refExamen')
        ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->select("tvaleurnormale.id","tvaleurnormale.designation","refExamen","detailValeur","tvaleurnormale.created_at",
        "tvaleurnormale.updated_at","texamen.designation as Examen","refCatexamen","tcategorieexament.designation as
        designationCat","refGrandCategorie","tgcategorieexament.designation as
        designationGCat","PrixExam","refTube","codeTube","designationTube","couleurTube","detailValeur","unite")
        ->orderBy("id", "desc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

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
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tvaleurnormale::where("id", $request->id)->update([
                'designation' =>  $request->designation,
                'refExamen' =>  $request->refExamen,
                'detailValeur' =>  $request->detailValeur,
                'unite' =>  $request->unite
                
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvaleurnormale::create([
                'designation' =>  $request->designation,
                'refExamen' =>  $request->refExamen,
                'detailValeur' =>  $request->detailValeur,
                'unite' =>  $request->unite
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
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
        $data = tvaleurnormale::where('id', $id)->get();
        return response()->json(['data' => $data]);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = tvaleurnormale::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
