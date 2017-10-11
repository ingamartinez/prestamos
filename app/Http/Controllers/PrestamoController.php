<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use App\Models\DispositivosPrestados;
use App\Models\Prestamo;
use App\Models\TipoPrestamo;
use App\Models\User;
use HttpOz\Roles\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Caffeinated\Flash\Facades\Flash;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prestamos = Prestamo::withTrashed()->get();

        return view('admin.prestamos.index',compact('prestamos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estudiantes = Role::findBySlug('estudiante')->users;
        $dispositivos = Dispositivo::all();
        $tipo_prestamos = TipoPrestamo::all();

        return view('admin.prestamos.create.index',compact('estudiantes','dispositivos','tipo_prestamos'));
    }

    public function realizar_prestamo(Request $request)
    {
        $datos= collect(json_decode($request->dispositivos[0],true));

        $prestamo = new Prestamo();
        $prestamo->users_id = $request->id_usuario;
        $prestamo->tipo_prestamo_id = $request->id_tipo_prestamo;
        $prestamo->save();

        foreach ($datos as $dato){
            $dispositivoPrestado = new DispositivosPrestados();
            $dispositivoPrestado->prestamos_id = $prestamo->id;
            $dispositivoPrestado->dispositivos_id = $dato['id'];
            $dispositivoPrestado->cantidad = $dato['cantidad'];

            $dispositivo = Dispositivo::findOrFail($dato['id']);
            $dispositivo->cantidad = (int) $dispositivo->cantidad - (int) $dato['cantidad'];

            $dispositivo->save();
            $dispositivoPrestado->save();
        }
        Flash::success('Prestamo realizado correctamente');

        return response()->json(['message'=>'Prestamo realizado correctamente'],200);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

//            Prestamo::findOrFail($id)->withTrashed()->delete();
            $prestamo = Prestamo::findOrFail($id);
            $prestamo->delete();

            $this->regresarArticulos($prestamo);

            DB::commit();

            Flash::success('Prestamo finalizado correctamente');

            return response()->json('Prestamo finalizado correctamente',200);

        }catch (\Exception $ex){
            DB::rollBack();

            //Flash::error('Error al editar - '.$ex->getMessage());

            return response()->json('No se puede finalizar el prestamo - '.$ex->getMessage(),404);
        };
    }


    private function regresarArticulos($prestamo) : void {
        $articulos = $prestamo->dispositivos;

        foreach ($articulos as $articulo){
            $articulo->cantidad = (int) $articulo->cantidad + (int) $articulo->pivot->cantidad;

            $articulo->save();
        }
    }
}
