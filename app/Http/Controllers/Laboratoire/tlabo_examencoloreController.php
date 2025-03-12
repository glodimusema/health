<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Laboratoire\{tlabo_examencolore};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tlabo_examencoloreController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tlabo_examencolore')
            ->select("tlabo_examencolore.id","tlabo_examencolore.nom_examencolore","author","tlabo_examencolore.created_at")
            ->where('nom_examencolore', 'like', '%'.$query.'%')
            ->orderBy("id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_examencolore')
            ->select("tlabo_examencolore.id","tlabo_examencolore.nom_examencolore","author","tlabo_examencolore.created_at")
            ->orderBy("id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tlabo_examencolore_2()
    {
        $data = DB::table('tlabo_examencolore')
        ->select("tlabo_examencolore.id","tlabo_examencolore.nom_examencolore","author","tlabo_examencolore.created_at")
        ->orderBy("id", "asc")
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
            $data = tlabo_examencolore::where("id", $request->id)->update([
                'nom_examencolore' =>  $request->nom_examencolore,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tlabo_examencolore::create([
                'nom_examencolore' =>  $request->nom_examencolore,
                'author' =>  $request->author
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
        $data = tlabo_examencolore::where('id', $id)->get();
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
        $data = tlabo_examencolore::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
