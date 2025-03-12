<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Laboratoire\{ttubeexamen};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class ttubeexamenController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('ttubeexamen')->select("ttubeexamen.id","ttubeexamen.designationTube","ttubeexamen.couleurTube","ttubeexamen.codeTube","ttubeexamen.author","ttubeexamen.created_at")
            ->where('designationTube', 'like', '%'.$query.'%')            
            ->orderBy("id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('ttubeexamen')->select("ttubeexamen.id","ttubeexamen.designationTube","ttubeexamen.codeTube","ttubeexamen.couleurTube","ttubeexamen.author","ttubeexamen.created_at")
            ->orderBy("id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_ttubeexamen_2()
    {
        $data = DB::table('ttubeexamen')->select("ttubeexamen.id","ttubeexamen.designationTube","ttubeexamen.codeTube","ttubeexamen.couleurTube","ttubeexamen.author","ttubeexamen.created_at")
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
            $data = ttubeexamen::where("id", $request->id)->update([
                'designationTube' =>  $request->designationTube,
                'codeTube' =>  $request->codeTube,
                'couleurTube' =>  $request->couleurTube,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');
        }
        else
        {
            // insertion 
            $data = ttubeexamen::create([
                'designationTube' =>  $request->designationTube,
                'codeTube' =>  $request->codeTube,
                'couleurTube' =>  $request->couleurTube,
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
        $data = ttubeexamen::where('id', $id)->get();
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
        $data = ttubeexamen::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
