<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affectations;
use App\Models\vAffectations;
use DB;

class AffetctationsController extends Controller
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
        
        $data = DB::table('affectations')
        ->join('client','client.id','=','affectations.refClient')
        ->join('personne','personne.id','=','affectations.refPersonne')
        
        ->select("affectations.id","affectations.refClient","client.name as nomClient","affectations.refPersonne","personne.name as nomPersonne","affectations.created_at","affectations.Date")->orderBy("affectations.id", "desc")->paginate(10);

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('client.name', 'like', '%'.$query.'%')
            ->orWhere('personne.name', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('affectations')
            ->join('client','client.id','=','affectations.refClient')
            ->join('personne','personne.id','=','affectations.refPersonne')
            ->select("affectations.id","affectations.refClient","client.name as nomClient","affectations.refPersonne","personne.name as nomPersonne","affectations.created_at","affectations.Date")->orderBy("affectations.id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }



    }


    public function fetch_client_affectation(Request $request,$refClient)
    {     
        
        $data = DB::table('affectations')
        ->join('client','client.id','=','affectations.refClient')
        ->join('personne','personne.id','=','affectations.refPersonne')
        
        ->select("affectations.id","affectations.refClient","client.name as nomClient","affectations.refPersonne","personne.name as nomPersonne","affectations.created_at","affectations.Date")->Where('affectations.refClient',$refClient)->orderBy("affectations.id", "desc")->paginate(10);

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('client.name', 'like', '%'.$query.'%')
            ->orWhere('personne.name', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('affectations')
            ->join('client','client.id','=','affectations.refClient')
            ->join('personne','personne.id','=','affectations.refPersonne')
            ->select("affectations.id","affectations.refClient","client.name as nomClient","affectations.refPersonne","personne.name as nomPersonne","affectations.created_at","affectations.Date")->Where('affectations.refClient',$refClient)->orderBy("affectations.id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }



    }



    //mes scripts
    function fetch_list_client()
    {

        $data = DB::table('client')->select("client.id","client.name","client.address","client.phone","client.created_at")->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    function fetch_list_personne()
    {

        $data = DB::table('personne')->select("personne.id","personne.name","personne.address","personne.phone","personne.created_at")->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_single_affectation($id)
    {

        $data = DB::table('affectations')
            ->join('client','client.id','=','affectations.refClient')
            ->join('personne','personne.id','=','affectations.refPersonne')
            ->select("affectations.id","affectations.refClient","client.name as nomClient","affectations.refPersonne","personne.name as nomPersonne","affectations.created_at","affectations.Date")->where('affectations.id', $id)->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   
    function insert_affectation(Request $request)
    {
       
        $data = Affectations::create([
            'refClient'       =>  $request->refClient,
            'refPersonne'    =>  $request->refPersonne,
            'Date'       =>  $request->Date
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_affectation(Request $request, $id)
    {
        $data = Affectations::where('id', $id)->update([
            'refClient'       =>  $request->refClient,
            'refPersonne'    =>  $request->refPersonne,
            'Date'       =>  $request->Date
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_affectation($id)
    {
        $data = Affectations::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

}
