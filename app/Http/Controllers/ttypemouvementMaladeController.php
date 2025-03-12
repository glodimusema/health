<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{ttypemouvement_malade};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class ttypemouvementMaladeController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('ttypemouvement_malade')->select("ttypemouvement_malade.id","ttypemouvement_malade.designation","ttypemouvement_malade.created_at")
            ->where('designation', 'like', '%'.$query.'%')            
            ->orderBy("designation", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('ttypemouvement_malade')->select("ttypemouvement_malade.id","ttypemouvement_malade.designation","ttypemouvement_malade.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_ttypemouvement_malade_2()
    {
        $data = DB::table('ttypemouvement_malade')->select("ttypemouvement_malade.id","ttypemouvement_malade.designation","ttypemouvement_malade.created_at")
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
     */
    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = ttypemouvement_malade::where("id", $request->id)->update([
                'designation' =>  $request->designation
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = ttypemouvement_malade::create([

                'designation' =>  $request->designation
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
        $data = ttypemouvement_malade::where('id', $id)->get();
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
        $data = ttypemouvement_malade::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
