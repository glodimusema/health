<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Logistique\tproduit;
use DB;

class tproduitController extends Controller
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
            # code...
            $query = $this->Gquery($request);

            $data=DB::table('tproduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')        
            ->select("tproduit.id","tproduit.designation as designation","pu","qte","unite","refCategorie",
            "tcategorieproduit.designation as designationCategorie","tproduit.created_at")
            ->where([
                ['tproduit.designation', 'like', '%'.$query.'%'],          
                ['tproduit.deleted','NON']
            ])
            ->orderBy("tproduit.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tproduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')        
            ->select("tproduit.id","tproduit.designation as designation","pu","qte","unite","refCategorie",
            "tcategorieproduit.designation as designationCategorie","tproduit.created_at")
            ->where([        
                ['tproduit.deleted','NON']
            ])
            ->orderBy("tproduit.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }

    //mes scripts
    function fetch_list_categorie()
    {

        $data = DB::table('tcategorieproduit')
        ->select("tcategorieproduit.id","tcategorieproduit.designation")
        ->where([        
            ['tcategorieproduit.deleted','NON']
        ])
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_list_produit2()
    {

        $data = DB::table('tproduit')
        ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')        
        ->select("tproduit.id","tproduit.designation as designation","refCategorie",
        "pu","unite","tcategorieproduit.designation as Categorie")
        ->where([        
            ['tproduit.deleted','NON']
        ])
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_single_produit2($id)
    {
        $data = DB::table('tproduit')
        ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')        
        ->select("tproduit.id","tproduit.designation as designation","pu","qte","unite","refCategorie",
        "tcategorieproduit.designation as designationCategorie","tproduit.created_at")
        ->where('tproduit.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
 
    function fetch_single_produit($id)
    {

        $data = DB::table('tproduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')        
            ->select("tproduit.id","tproduit.designation as designation","pu","qte","unite","refCategorie",
            "tcategorieproduit.designation as designationCategorie","tproduit.created_at")
            ->where('tproduit.id', $id)->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   
    function insert_produit(Request $request)
    {
       //designation,pu,qte,unite,refCategorie,author
        $data = tproduit::create([
            'designation'       =>  $request->designation,
            'pu'    =>  $request->pu,
            'unite'    =>  $request->unite,
            'refCategorie'    =>  $request->refCategorie,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_produit(Request $request, $id)
    {
        $data = tproduit::where('id', $id)->update([
            'designation'       =>  $request->designation,
            'pu'    =>  $request->pu,            
            'unite'    =>  $request->unite,
            'refCategorie'    =>  $request->refCategorie,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_produit($id)
    {
        $data = tproduit::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
