<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\DTO\IncidenciasDTO;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facaces\Http;

class PostController extends Controller{

//// FUNCION QUE DEVUELVE TODAS LAS INCIDENCIAS ////
    public function getAll(){
        // Uso Try para controlar errores
        try{
            // Consulta directa sobre la base de datos
            $data = DB::table('incidencias')
                                ->join('trabajadores','incidencias.idTrabajador','trabajadores.idTrabajador')
                                ->join('instalaciones','incidencias.idInstalacion','instalaciones.idInstalacion')
                                ->orderBy('id','asc')
                                ->get();

            // Mapeo de la respuesta para poder enviar datos de las otras tablas como los nombres //
            $incidencias = $data->map(fn($incidencia)=>new IncidenciasDTO(
                                                            $incidencia->id,
                                                            $incidencia->idTrabajador,
                                                            $incidencia->nombreTrabajador,
                                                            $incidencia->idInstalacion,
                                                            $incidencia->nombreInstalacion,
                                                            $incidencia->hora,
                                                            $incidencia->descripcion)
                                    );
            
            return response()->json([
                "status" => "success",
                "code" => 200,
                "time" => now()->toIso8601String(), // Utiliza la función de Laravel para obtener la hora en formato ISO-8601
                "message" => "Base de datos con todas las incidencias",
                "data" => $incidencias
            ],200);

        }catch(\Exception $e){
            // Recogida de informacion del fallo si lo hubiera en el proceso de creación
            return response()->json([
                "status" => "error",
                "code" => 500,
                "message" => "Ocurrió un error con la base de datos",
                "error" => $e->getMessage()
            ], 500);
        }

    }

//// FUNCION QUE DEVUELVE UNA INCIDENCIA BUSCADA POR ID ////
    public function getById($id){

        try{
            // Consulta directa sobre la tabla que corresponde con el modelo
            $incidencia = Incidencia::find($id);
            
            // Control busqueda de incidencia
            if (!$incidencia) {
                return response()->json([
                    "status" => "error",
                    "code" => 406,
                    "time" => now()->toIso8601String(),
                    "message" => "Incidencia no encontrada",
                    "data" => null
                ], 406);
            }

            return response()->json([
                "status" => "success",
                "code" => 200,
                "time" => now()->toIso8601String(), // Utiliza la función de Laravel para obtener la hora en formato ISO-8601
                "message" => "Base de datos con la incidencia buscada",
                "data" => $incidencia
            ]);

        }catch(\Exception $e){
            // Recogida de informacion del fallo si lo hubiera en el proceso de creación
            return response()->json([
                "status" => "error",
                "code" => 500,
                "message" => "Ocurrió un error con la base de datos",
                "error" => $e->getMessage()
            ], 500);
        }
    }
//// FUNCION QUE CREA UNA INCIDENCIA ////
    public function createIncidencia(Request $data){
        
        try {
            // Validado de los datos recibidos
            $dataVal = $data->validate([
                'idTrabajador' => 'required|integer',
                'idInstalacion' => 'required|integer',
                'hora' => 'required|string',
                'descripcion' => 'required|string'
            ]);

            // Crear la incidencia
            $incidencia = Incidencia::create($dataVal);
            
            return response()->json([
                "status" => "success",
                "code" => 201,
                "time" => now()->toIso8601String(), // Fecha en formato ISO-8601
                "message" => "Incidencia creada correctamente",
                "data" => $incidencia
            ], 201);

        } catch (\Exception $e) {
            // Recogida de informacion del fallo si lo hubiera en el proceso de creación
            return response()->json([
                "status" => "error",
                "code" => 500,
                "message" => "Ocurrió un error con la base de datos",
                "error" => $e->getMessage()
            ], 500);
        }
    }

//// FUNCION QUE ACTUALIZA UNA INCIDENCIA ////
    public function updateIncidencia($id, Request $data){
        
        try{
            // Validado de los datos recibidos
            $dataVal = $data->validate([
                'idTrabajador' => 'required|integer',
                'idInstalacion' => 'required|integer',
                'hora' => 'required|string',
                'descripcion' => 'required|string'
            ]);

            $incidencia = Incidencia::find($id);

            if(!$incidencia){
                return response()->json([
                    "status" => "error",
                    "code" => 406,
                    "time" => now()->toIso8601String(),
                    "message" => "Incidencia no encontrada",
                    "data" => "id = ".$id
                ], 406);
            }
            // Actualizar incidencia
            $incidencia->update($dataVal);

            return response()->json([
                "status" => "success",
                "code" => 201,
                "time" => date('c'), // Fecha y hora en formato ISO-8601
                "message" => "Datos con la incidencia MODIFICADA",
                "data" => $incidencia
            ]);

        }catch(\Exception $e){
            // Recogida de informacion del fallo si lo hubiera en el proceso de creación
            return response()->json([
                "status" => "error",
                "code" => 500,
                "message" => "Ocurrió un error con la base de datos",
                "error" => $e->getMessage()
            ], 500);
        }
    }

//// FUNCION QUE BORRA UNA INCIDENCIA ////
    public function deleteIncidencia($id){
        
        try{
            $incidencia = Incidencia::find($id);

            if(!$incidencia){

                return response()->json([
                    "status" => "error",
                    "code" => 406,
                    "time" => now()->toIso8601String(),
                    "message" => "Incidencia no encontrada",
                    "data" => "id = ".$id
                ], 406);
            }

            $incidencia->delete($id);

            return response()->json([
                "status" => "success",
                "code" => 204,
                "time" => now()->toIso8601String(),
                "message" => "Incidencia eliminada = ".$id
            ], 200);

        }catch(\Exception $e){
            // Recogida de informacion del fallo si lo hubiera en el proceso de creación
            return response()->json([
                "status" => "error",
                "code" => 500,
                "time" => now()->toIso8601String(),
                "message" => "Ocurrió un error con la base de datos",
                "error" => $e->getMessage()
            ], 500);

        }
    }
}