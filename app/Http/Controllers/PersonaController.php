<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request )
    {
        $buscar=isset($request->q)?$request->q : '';
        $limit =isset($request->limit)?$request->limit:10;

        if($buscar)
        {
            $pe=Persona::ordeBy('id','desc')
            ->where('ci','like','%'.$buscar.'%')
            ->paginate('$limit');  
        }
        else
        {
            $pe=Persona::orderBy('id','desc')->paginate($limit);
        }
        return response()->json($pe, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ci'=>'required'
        ]);
        $pe=new Persona();
        $pe->ci=$request->ci;
        $pe->nombres=$request->nombres;
        $pe->paterno=$request->paterno;
        $pe->materno=$request->materno;
        $pe->direccion=$request->direccion;
        $pe->save();
        return response()->json(["message" => "registrado"], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            
            "ci"=>"required|unique:personas,ci,$id"
            
        ]);
        $pe=Persona::findOrFail($id);
        $pe->ci=$request->ci;
        $pe->nombres=$request->nombres;
        $pe->paterno=$request->paterno;
        $pe->materno=$request->materno;
        $pe->direccion=$request->direccion;
        $pe->update();
        return response()->json(["message" => "actualizado"], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pro=Persona::find($id);
        $pro->delete();
        return response()->json(["message" => "Eliminada"], 200);
    }
}
