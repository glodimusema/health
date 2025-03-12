<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{tcategorieclient};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class categorieclientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tcategorieclient')->select("tcategorieclient.id","tcategorieclient.designation","tcategorieclient.created_at")->where('designation', 'like', '%'.$query.'%')
            ->orWhere('designation', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tcategorieclient')->select("tcategorieclient.id","tcategorieclient.designation","tcategorieclient.created_at")->orderBy("id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tcategorieclient_2()
    {
        $data = DB::table('tcategorieclient')->select("tcategorieclient.id","tcategorieclient.designation","tcategorieclient.created_at")->orderBy("id", "desc")->paginate(10);
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
            $data = tcategorieclient::where("id", $request->id)->update([
                'designation' =>  $request->designation
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tcategorieclient::create([

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
        $data = tcategorieclient::where('id', $id)->get();
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
        $data = tcategorieclient::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
