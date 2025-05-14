<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trabajador;

use Illuminate\Support\Facades\DB;

class TrabajadorController extends Controller
{
    //// FUNCION QUE DEVUELVE TOD@S L@S TRABAJADORES ////
    public function getAll(){
        // Uso Try para controlar errores
        try{
            
            $trabajadores = Trabajador::all();
            
            return response()->json([
                "status" => "success",
                "code" => 200,
                "time" => now()->toIso8601String(), // Utiliza la función de Laravel para obtener la hora en formato ISO-8601
                "message" => "Base de datos con todos los trabajadores",
                "data" => $trabajadores
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

//// FUNCION QUE DEVUELVE UN/A TRABAJADOR/A BUSCADA POR ID ////
    public function getById($id){

        try{
            // Consulta directa sobre la tabla que corresponde con el modelo
            $trabajador = Trabajador::find($id);
            
            // Control busqueda de incidencia
            if (!$trabajador) {
                return response()->json([
                    "status" => "error",
                    "code" => 406,
                    "time" => now()->toIso8601String(),
                    "message" => "Trabajador no encontrada",
                    "data" => null
                ], 406);
            }

            return response()->json([
                "status" => "success",
                "code" => 200,
                "time" => now()->toIso8601String(), // Utiliza la función de Laravel para obtener la hora en formato ISO-8601
                "message" => "Datos con el trabajador buscado",
                "data" => $trabajador
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
//// FUNCION QUE CREA UN/A TRABAJADOR/A ////
    public function createTrabajador(Request $data){
        
        try {
            // Validado de los datos recibidos
            $dataVal = $data->validate([
                'idTrabajador' => 'required|integer',
                'nombreTrabajador' => 'required',
                'apellido1' => 'required',
                'apellido2' => 'required',
                'dni' => 'required',
                'telefono'=> 'required',
                'direccion'=> 'required',
                'email'=> 'required|email',
            ]);

            // Crear trabajador/a
            $trabajador = Trabajador::create($dataVal);
            
            return response()->json([
                "status" => "success",
                "code" => 201,
                "time" => now()->toIso8601String(), // Fecha en formato ISO-8601
                "message" => "Incidencia creada correctamente",
                "data" => $trabajador
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

//// FUNCION QUE ACTUALIZA UN/A TRABAJADOR/A ////
    public function updateTrabajador($id, Request $data){
        
        try{
            // Validado de los datos recibidos
            $dataVal = $data->validate([
                //'idTrabajador' => 'required',
                'nombreTrabajador' => 'required',
                'apellido1' => 'required',
                'apellido2' => 'required',
                'dni' => 'required',
                'telefono'=> 'required',
                'direccion'=> 'required',
                'email'=> 'required|email',
            ]);

            $trabajador = Trabajador::find($id);

            if(!$trabajador){
                return response()->json([
                    "status" => "error",
                    "code" => 406,
                    "time" => now()->toIso8601String(),
                    "message" => "Trabajador no encontrado",
                    "data" => "id = ".$id
                ], 406);
            }
            // Actualizar trabajador/a
            $trabajador->update($dataVal);

            return response()->json([
                "status" => "success",
                "code" => 201,
                "time" => date('c'), // Fecha y hora en formato ISO-8601
                "message" => "Datos con la incidencia MODIFICADA",
                "data" => $trabajador
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

//// FUNCION QUE BORRA UN TRABAJADOR / NOSERA POSIBLE SI TIENE INCIDENCIAS REGISTRADAS ////
    public function deleteTrabajador($id){
        
        try{
            $trabajador = Trabajador::find($id);

            if(!$trabajador){

                return response()->json([
                    "status" => "error",
                    "code" => 406,
                    "time" => now()->toIso8601String(),
                    "message" => "Trabajador no encontrado",
                    "data" => "id = ".$id
                ], 406);
            }

            $trabajador->delete($id);

            return response()->json([
                "status" => "success",
                "code" => 204,
                "time" => now()->toIso8601String(),
                "message" => "Trabajador eliminado = ".$id
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
