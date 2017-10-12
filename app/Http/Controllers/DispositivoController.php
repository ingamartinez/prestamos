<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use App\Models\TipoDispositivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Caffeinated\Flash\Facades\Flash;

class DispositivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validar(Request $request){
        $request->validate([
            'nombre' => 'bail|required|max:191',
            'cantidad' => 'bail|required|int|max:191',
            'select-tipo-dispositivo' => 'bail|required',
        ]);
    }
    public function index()
    {
        $dispositivos = Dispositivo::withTrashed()->get();
        $tipo_dispositivos = TipoDispositivo::withTrashed()->get();

        return view('admin.gestion_dispositivos.index',compact('dispositivos','tipo_dispositivos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'bail|required|max:191',
            'cantidad' => 'bail|required|int|max:191',
            'select-tipo-dispositivo' => 'bail|required',
        ]);

        try{
            DB::beginTransaction();

            $dispositivo = new Dispositivo();
            $dispositivo->nombre = $request->nombre;
            $dispositivo->cantidad = $request->cantidad;
            $dispositivo->tipo_dispositivo_id = $request->input('select-tipo-dispositivo');

            $dispositivo->save();

            Flash::success('Dispositivo creado correctamente');

//            throw new \Exception('No se pudo crear el usuario');

            DB::commit();

            return redirect()->back();
        }catch (\Exception $ex){
            DB::rollBack();

            Flash::error('Error al crear - '.$ex->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $user = Dispositivo::with('tipo_dispositivo')->findOrFail($id);

//            $rolID=[];
//            foreach ($user->roles as $rol){
//                $rolID=$rol->id;
//            }
//            $user->rol_id = $rolID;

//            dd($user);

            return response()->json($user,200);

        }catch (\Exception $ex){
            return response()->json(['message'=>'No se encuentra el dispositivo'],404);
//            return response()->json(['message'=>$ex],404);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dispositivo = Dispositivo::withTrashed()->findOrFail($id);

        try{
            DB::beginTransaction();

            $dispositivo->nombre = $request->nombre;
            $dispositivo->cantidad = $request->cantidad;
            $dispositivo->tipo_dispositivo_id = $request->input('select-tipo-dispositivo');

            $dispositivo->save();

            DB::commit();

            Flash::success('Dispositivo editado correctamente');

            return response()->json($dispositivo,200);

        }catch (\Exception $ex){
            DB::rollBack();

            Flash::error('Error al editar - '.$ex->getMessage());

            return response()->json(['message'=>'No se encuentra el dispositivo'],404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        try{
            DB::beginTransaction();

            //throw new \Exception('No se pudo crear el usuario');

            $user= Dispositivo::destroy($id);

            DB::commit();

            Flash::success('Dispositivo eliminado correctamente');

            return response()->json('Dispositivo eliminado correctamente',200);

        }catch (\Exception $ex){
            DB::rollBack();

            //Flash::error('Error al editar - '.$ex->getMessage());

            return response()->json('No se puede eliminar el dispositivo',404);
        }


    }
    public function restore($id)
    {
        try{
            DB::beginTransaction();

            //throw new \Exception('No se pudo crear el usuario');

            Dispositivo::withTrashed()->findOrFail($id)->restore();

            DB::commit();

            Flash::success('Dispositivo restaurado correctamente');

            return response()->json('Dispositivo Restaurado correctamente',200);

        }catch (\Exception $ex){
            DB::rollBack();

            //Flash::error('Error al editar - '.$ex->getMessage());

            return response()->json('No se pudo restaurar el dispositivo',404);
        }


    }
}
