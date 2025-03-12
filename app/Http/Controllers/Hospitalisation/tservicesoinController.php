<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Hospitalisation\{tservicesoin};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tservicesoinController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
               
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tservicesoin')
            ->select('id','nom_servicesoin',"tservicesoin.created_at")
            ->where('nom_servicehospi', 'like', '%'.$query.'%')           
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tservicesoin')
            ->select('id','nom_servicesoin',"tservicesoin.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_servicesoin_2()
    {
        $data = DB::table('tservicesoin')
        ->select('id','nom_servicesoin',"tservicesoin.created_at")
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
        if ($request->id !='') 
        {
            // update 
            $data = tservicesoin::where("id", $request->id)->update([
                'nom_servicesoin' =>  $request->nom_servicesoin
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tservicesoin::create([
                'nom_servicesoin' =>  $request->nom_servicesoin
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
        $data = tservicesoin::where('id', $id)->get();
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
        $data = tservicesoin::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
