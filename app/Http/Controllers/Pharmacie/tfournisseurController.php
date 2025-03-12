<?php

namespace App\Http\Controllers\Pharmacie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacie\{tfournisseur};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tfournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tfournisseur')->select("tfournisseur.id","tfournisseur.noms","tfournisseur.contact",
            "tfournisseur.mail","tfournisseur.adresse","tfournisseur.author","tfournisseur.created_at")
            ->where('noms', 'like', '%'.$query.'%')
            ->orWhere('adresse', 'like', '%'.$query.'%')
            ->orWhere('contact', 'like', '%'.$query.'%')
            ->orWhere('mail', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tfournisseur')->select("tfournisseur.id","tfournisseur.noms","tfournisseur.contact",
            "tfournisseur.mail","tfournisseur.adresse","tfournisseur.author","tfournisseur.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    function fetch_pays_2()
    {
        $data = DB::table('tfournisseur')->select("tfournisseur.id","tfournisseur.noms","tfournisseur.contact",
        "tfournisseur.mail","tfournisseur.adresse","tfournisseur.author","tfournisseur.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
        return response()->json([
            'data'  => $data,
        ]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * id','noms','contact','mail','adresse','author'
     */


    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tfournisseur::where("id", $request->id)->update([
                'noms' =>  $request->noms,
                'contact' =>  $request->contact,
                'mail' =>  $request->mail,
                'adresse' =>  $request->adresse,
                'author' =>  "admin"
                //'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tfournisseur::create([
                'noms' =>  $request->noms,
                'contact' =>  $request->contact,
                'mail' =>  $request->mail,
                'adresse' =>  $request->adresse,
                'author' =>  "admin"
                // 'author' =>  $request->author
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
        $data = tfournisseur::where('id', $id)->get();
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
        $data = tfournisseur::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
