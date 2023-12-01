<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MovimientoController extends Controller
{
    /**
     * Lista todos los movimientos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $userId = Auth::id();
        $fechaInicio = $request->input('fecha_inicio', date('Y-m-01'));
        $fechaFin = $request->input('fecha_fin', date('Y-m-t'));

        $mov = Movimiento::where('user_id', $userId)
        ->whereBetween('created_at', [$fechaInicio.' 00:00:00', $fechaFin.' 23:59:59'])
        ->get();
        return response()->json([
            'success'=>true,
            'results'=> $mov
        ]);
    }

    /**
     * Devuelve un movimiento específico.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = Auth::id();
        $mov = Movimiento::where('user_id', $userId)->where('id',$id)->first();
        if($mov){

            return response()->json([
                'success'=>true,
                'results'=> $mov
            ]);
        }
        return response()->json([
            'success'=>false,
        ],404);

    }

    /**
     * Crea un nuevo movimiento.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $validator = Validator::make($request->all(), [
            'detalles' => 'required|string|max:255', // Detalles es una cadena de texto de máximo 255 caracteres.
            'tipo' => [
                'required',
                Rule::in([0, 1]) // Tipo debe ser 0 o 1.
            ],
            'modo' => [
                'required',
                Rule::in([0, 1]) // Modo debe ser 0 o 1.
            ],
            'valor' => 'required|numeric', // Valor debe ser un número.
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message'=> $validator->errors()
            ], 422);
        }

        try {
            $mov = Movimiento::create([
                'detalles'=>$request->detalles,
                'valor'=>$request->valor,
                'modo'=>$request->modo,
                'user_id'=>$userId
            ]);
            return response()->json([
                'success'=>true,
                'results'=>$mov
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success'=>true,
                'message'=>'Server error'
            ],500);
            Log::debug($th);
        }


    }

    /**
     * Actualiza un movimiento existente.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'detalles' => 'required|string|max:255', // Detalles es una cadena de texto de máximo 255 caracteres.
            'tipo' => [
                'required',
                Rule::in([0, 1]) // Tipo debe ser 0 o 1.
            ],
            'modo' => [
                'required',
                Rule::in([0, 1]) // Modo debe ser 0 o 1.
            ],
            'valor' => 'required|numeric', // Valor debe ser un número.
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message'=> $validator->errors()
            ], 422);
        }
        $mov = Movimiento::findOrFail($id);

        // Actualizar los campos del movimiento con los nuevos valores proporcionados en la solicitud.


        try {
            $mov->update([
                'detalles' => $request->input('detalles'),
                'tipo' => $request->input('tipo'),
                'modo' => $request->input('modo'),
                'valor' => $request->input('valor'),
            ]);
            return response()->json([
                'success'=>true,
                'results'=>$mov
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success'=>true,
                'message'=>'Server error'
            ],500);
            Log::debug($th);
        }

    }

    /**
     * Elimina un movimiento existente.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movimiento = Movimiento::find($id);
        $movimiento->delete();

        return response()->json(['success' => true]);
    }
}
