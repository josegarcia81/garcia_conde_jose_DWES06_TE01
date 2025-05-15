<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\DTO\IncidenciasDTO;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PostController extends Controller{

//// FUNCION QUE DEVUELVE TODAS LAS INCIDENCIAS ////
    public function getAll(){
        // Uso Try para controlar errores
        try{
            $response = Http::get('http://localhost:8080/spring/getAll');
            // Respuesta ok
            return response()->json([
                "status" => "success",
                "code" => 200,
                "time" => now()->toIso8601String(), // Utiliza la función de Laravel para obtener la hora en formato ISO-8601
                "message" => "Base de datos con todas las incidencias",
                "data" => $response->json()
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
            $response = Http::get('http://localhost:8080/spring/getById/'.$id);
            // Control busqueda de incidencia
            if ($response->status() === 404) {
                return response()->json([
                    "status" => "error",
                    "code" => 406,
                    "time" => now()->toIso8601String(),
                    "message" => "Incidencia no encontrada",
                    "data" => null
                ], 406);
            }
            // Respuesta ok
            return response()->json([
                "status" => "success",
                "code" => 200,
                "time" => now()->toIso8601String(), // Utiliza la función de Laravel para obtener la hora en formato ISO-8601
                "message" => "Base de datos con la incidencia buscada",
                "data" => $response->json() 
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

            $response = Http::post('http://localhost:8080/spring/create',$dataVal);
            
            return response()->json([
                "status" => "success",
                "code" => 201,
                "time" => now()->toIso8601String(), // Fecha en formato ISO-8601
                "message" => "Incidencia creada correctamente",
                "data" => $response->json()
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

            $response = Http::put('http://localhost:8080/spring/update/'.$id,$dataVal);
            // Control de incidencia no encontrada
            if(!$response->successful()){
                return response()->json([
                    "status" => "error",
                    "code" => 406,
                    "time" => now()->toIso8601String(),
                    "message" => "Incidencia no encontrada",
                    "data" => $response->json()
                ],406);
            }
            // Respuesta ok
            return response()->json([
                "status" => "success",
                "code" => 201,
                "time" => date('c'), // Fecha y hora en formato ISO-8601
                "message" => "Datos con la incidencia MODIFICADA",
                "data" => $response->json()
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
            $response = Http::delete('http://localhost:8080/spring/delete/'.$id);
            
            if(!$response->successful()){

                return response()->json([
                    "status" => "error",
                    "code" => 406,
                    "time" => now()->toIso8601String(),
                    "message" => "Incidencia no encontrada",
                    "data" => $response->body()
                ], 406);
            }
            // Respuesta ok
            return response()->json([
                "status" => "success",
                "code" => 204,
                "time" => now()->toIso8601String(),
                "message" => "Incidencia eliminada = ".$id,
                "data" => $response->body()
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