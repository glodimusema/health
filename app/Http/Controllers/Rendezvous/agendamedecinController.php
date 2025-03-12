<?php

namespace App\Http\Controllers\Rendezvous;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Rendezvous\{tagendamedecin};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class agendamedecinController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tagendamedecin')
            ->select("id","refUser","dateRDV","noms","contact","lieu","motif","statut","author","created_at")
            ->selectRaw('TIMESTAMPDIFF(DAY, dateRDV, CURDATE()) as duree')
            ->where('noms', 'like', '%'.$query.'%')  
            ->orWhere('author', 'like', '%'.$query.'%')          
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tagendamedecin')
            ->select("id","refUser","dateRDV","noms","contact","lieu","motif","statut","author","created_at")
            ->selectRaw('TIMESTAMPDIFF(DAY, dateRDV, CURDATE()) as duree')
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }

    public function fetch_agenda_for_medecin(Request $request,$refEntete)
    {  
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tagendamedecin')
            ->select("id","refUser","dateRDV","noms","contact","lieu","motif","statut","author","created_at")
            ->selectRaw('TIMESTAMPDIFF(DAY, dateRDV, CURDATE()) as duree')
            ->Where('refUser',$refEntete);
            $data->Where('noms', 'like', '%'.$query.'%')           
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tagendamedecin')
            ->select("id","refUser","dateRDV","noms","contact","lieu","motif","statut","author","created_at")
            ->selectRaw('TIMESTAMPDIFF(DAY, dateRDV, CURDATE()) as duree')
            ->Where('refUser',$refEntete)
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    




    function fetch_single_agenda($id)
    {

        $data = DB::table('tagendamedecin')
        ->select("id","refUser","dateRDV","noms","contact","lieu","motif","statut","author","created_at")
        ->selectRaw('TIMESTAMPDIFF(DAY, dateRDV, CURDATE()) as duree')
        ->where('id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_tagendamedecin_2()
    {
        $data = DB::table('tagendamedecin')
        ->select("tid","refUser","dateRDV","noms","contact","lieu","motif","statut","author","created_at")
        ->selectRaw('TIMESTAMPDIFF(DAY, dateRDV, CURDATE()) as duree')
        ->orderBy("id", "desc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

    }

    //id,refUser,dateRDV,noms,contact,lieu,motif,statut,author
    function insert_agenda(Request $request)
    {
       
        $data = tagendamedecin::create([
            'refUser'       =>  $request->refUser,
            'dateRDV'    =>  $request->dateRDV,
            'noms'    =>  $request->noms,
            'contact'    =>  $request->contact,
            'lieu'    =>  $request->lieu,
            'motif'    =>  $request->motif,
            'statut'    =>  $request->statut,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_agenda(Request $request, $id)
    {
        $data = tagendamedecin::where('id', $id)->update([
            'refUser'       =>  $request->refUser,
            'dateRDV'    =>  $request->dateRDV,
            'noms'    =>  $request->noms,
            'contact'    =>  $request->contact,
            'lieu'    =>  $request->lieu,
            'motif'    =>  $request->motif,
            'statut'    =>  $request->statut,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_statut_agenda(Request $request, $id)
    {
        $data = tagendamedecin::where('id', $id)->update([            
            'statut'    =>  $request->statut,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_agenda($id)
    {
        $data = tagendamedecin::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

}
