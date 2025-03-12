<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Laboratoire\{texamen};
use App\Models\Laboratoire\{vExament};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class texamenController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('texamen')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->select("texamen.id","texamen.designation","refCatexamen","texamen.created_at",
            "texamen.updated_at","tcategorieexament.designation as designationCat","refGrandCategorie",
            "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube","designationTube","couleurTube")
            ->where('texamen.designation', 'like', '%'.$query.'%')
            ->orWhere('texamen.designation', 'like', '%'.$query.'%')
            ->orWhere('designationTube', 'like', '%'.$query.'%')
            ->orderBy("texamen.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('texamen')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->select("texamen.id","texamen.designation","refCatexamen","texamen.created_at",
            "texamen.updated_at","tcategorieexament.designation as designationCat","refGrandCategorie",
            "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube","designationTube","couleurTube")
            ->orderBy("texamen.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }

    function fetch_single_examen($id)
    {
        $data = DB::table('texamen')
        ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->select("texamen.id","texamen.designation","refCatexamen","texamen.created_at",
        "texamen.updated_at","tcategorieexament.designation as designationCat","refGrandCategorie",
        "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube",
        "designationTube","couleurTube")
        ->where('texamen.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_texamen_2()
    {
        $data = DB::table('texamen')
        ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->select("texamen.id","texamen.designation","refCatexamen","texamen.created_at",
        "texamen.updated_at","tcategorieexament.designation as designationCat","refGrandCategorie",
        "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube","designationTube","couleurTube")
        ->orderBy("texamen.id", "desc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

    }

    function fetch_list_Tube()
    {
        $data = DB::table('ttubeexamen')
        ->select("ttubeexamen.id","ttubeexamen.designationTube")
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
            # ...
            // update 
            $data = texamen::where("id", $request->id)->update([
                'designation' =>  $request->designation,
                'PrixExam' =>  $request->PrixExam,
                'refCatexamen' =>  $request->refCatexamen,
                'refTube' =>  $request->refTube
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = texamen::create([
                'designation' =>  $request->designation,
                'PrixExam' =>  $request->PrixExam,
                'refCatexamen' =>  $request->refCatexamen,
                'refTube' =>  $request->refTube
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
        $data = texamen::where('id', $id)->get();
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
        $data = texamen::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
