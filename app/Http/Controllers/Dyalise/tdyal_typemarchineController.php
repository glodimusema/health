<?php

namespace App\Http\Controllers\Dyalise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dyalise\{tdyal_type_machine};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;
  


class tdyal_typemarchineController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tdyal_type_machine')->select("tdyal_type_machine.id",
            "tdyal_type_machine.nomTypeMachine","description"
            ,"tdyal_type_machine.created_at")->where('nomTypeMachine', 'like', '%'.$query.'%')
            ->orWhere('description', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tdyal_type_machine')->select("tdyal_type_machine.id",
            "tdyal_type_machine.nomTypeMachine","description"
            ,"tdyal_type_machine.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_type_machine2()
    {
        $data = DB::table('tdyal_type_machine')->select("tdyal_type_machine.id",
        "tdyal_type_machine.nomTypeMachine","description",
        "tdyal_type_machine.created_at")
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
            $data = tdyal_type_machine::where("id", $request->id)->update([
                'nomTypeMachine' =>  $request->nomTypeMachine,
                'description'=> $request->description
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdyal_type_machine::create([
                'nomTypeMachine' =>  $request->nomTypeMachine,
                'description'=> $request->description
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
        $data = tdyal_type_machine::where('id', $id)->get();
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
        $data = tdyal_type_machine::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
