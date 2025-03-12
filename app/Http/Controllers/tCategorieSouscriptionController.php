<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{tCategorieSouscription};
use App\Traits\{GlobalMethod,Slug};
use DB;
use App\User;
use App\Message;

class tCategorieSouscriptionController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tcategoriesouscription')->select("tcategoriesouscription.id","tcategoriesouscription.designation","tcategoriesouscription.prix","tcategoriesouscription.created_at")->where('designation', 'like', '%'.$query.'%')
            ->orWhere('designation', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tcategoriesouscription')->select("tcategoriesouscription.id","tcategoriesouscription.designation","tcategoriesouscription.prix","tcategoriesouscription.created_at")->orderBy("id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tcategoriesouscription_2()
    {
        $data = DB::table('tcategoriesouscription')->select("tcategoriesouscription.id","tcategoriesouscription.designation","tcategoriesouscription.prix","tcategoriesouscription.created_at")->orderBy("id", "desc")->paginate(10);
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
            $data = tCategorieSouscription::where("id", $request->id)->update([
                'designation' =>  $request->designation,
                'prix' =>  $request->prix
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tCategorieSouscription::create([

                'designation' =>  $request->designation,
                'prix' =>  $request->prix
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
        $data = tCategorieSouscription::where('id', $id)->get();
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
        $data = tCategorieSouscription::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
