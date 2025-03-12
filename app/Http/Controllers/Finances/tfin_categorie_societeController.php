<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tfin_categorie_societe};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tfin_categorie_societeController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tfin_categorie_societe')
            ->select("tfin_categorie_societe.id","tfin_categorie_societe.name_categorie_societe","tfin_categorie_societe.created_at")->where('name_categorie_societe', 'like', '%'.$query.'%')
            ->orWhere('name_categorie_societe', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tfin_categorie_societe')
            ->select("tfin_categorie_societe.id","tfin_categorie_societe.name_categorie_societe","tfin_categorie_societe.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tfin_categorie_societe_2()
    {
        $data = DB::table('tfin_categorie_societe')
        ->select("tfin_categorie_societe.id","tfin_categorie_societe.name_categorie_societe","tfin_categorie_societe.created_at")
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
            $data = tfin_categorie_societe::where("id", $request->id)->update([
                'name_categorie_societe' =>  $request->name_categorie_societe
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tfin_categorie_societe::create([

                'name_categorie_societe' =>  $request->name_categorie_societe
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
        $data = tfin_categorie_societe::where('id', $id)->get();
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
        $data = tfin_categorie_societe::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
