<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Laboratoire\{tcategorieexamen};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tcategorieexamenController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tcategorieexament')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->select("tcategorieexament.id","tcategorieexament.refGrandCategorie",
            "tcategorieexament.designation as designation","tgcategorieexament.designation as designationGCat")
            ->where('tcategorieexament.designation', 'like', '%'.$query.'%')            
            ->orderBy("tcategorieexament.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tcategorieexament')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->select("tcategorieexament.id","tcategorieexament.refGrandCategorie",
            "tcategorieexament.designation as designation","tgcategorieexament.designation as designationGCat")
            ->orderBy("tcategorieexament.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tcategorieexamen_2()
    {
        $data = DB::table('tcategorieexament')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->select("tcategorieexament.id","tcategorieexament.refGrandCategorie",
        "tcategorieexament.designation as designation","tgcategorieexament.designation as designationGCat")
        ->orderBy("tcategorieexament.id", "desc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

    }


    function insert_categorie(Request $request)
    {
       //designation,pu,qte,unite,refCategorie,author
        $data = tcategorieexamen::create([
            'designation' =>  $request->designation,
            'refGrandCategorie' =>  $request->refGrandCategorie
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_categorie(Request $request, $id)
    {
        $data = tcategorieexamen::where('id', $id)->update([
            'designation' =>  $request->designation,
            'refGrandCategorie' =>  $request->refGrandCategorie
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
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
            $data = tcategorieexamen::where("id", $request->id)->update([
                'designation' =>  $request->designation,
                'refGrandCategorie' =>  $request->refGrandCategorie
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tcategorieexamen::create([
                'designation' =>  $request->designation,
                'refGrandCategorie' =>  $request->refGrandCategorie
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
        $data = tcategorieexamen::where('id', $id)->get();
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
        $data = tcategorieexamen::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
