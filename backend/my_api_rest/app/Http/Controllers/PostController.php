<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incidencia;
use App\DTO\IncidenciasDTO;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Documentación API de Incidencias",
 *      description="API Middleware en Laravel para gestión de incidencias comunicándose con Microservicio Spring Boot",
 *      @OA\Contact(
 *          email="txema@mail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 */
class PostController extends Controller{

    /**
     * @OA\Get(
     *      path="/api/public/post/get",
     *      operationId="getIncidenciasList",
     *      tags={"Incidencias"},
     *      summary="Obtener lista de incidencias",
     *      description="Retorna la lista completa de incidencias registradas en la base de datos externa",
     *      @OA\Response(
     *          response=200,
     *          description="Operación exitosa",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *          )
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Error interno del servidor"
     *      )
     *     )
     */
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

    /**
     * @OA\Get(
     *      path="/api/public/post/get/{id}",
     *      operationId="getIncidenciaById",
     *      tags={"Incidencias"},
     *      summary="Obtener información de una incidencia específica",
     *      description="Retorna los datos de una incidencia basada en su ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la incidencia",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Incidencia encontrada",
     *          @OA\JsonContent(type="object")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Incidencia no encontrada"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error interno del servidor"
     *      )
     * )
     */
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
    /**
     * @OA\Post(
     *      path="/api/public/post/create",
     *      operationId="createIncidencia",
     *      tags={"Incidencias"},
     *      summary="Crear una nueva incidencia",
     *      description="Registra una nueva incidencia en el sistema y la envía al microservicio",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"idTrabajador","idInstalacion","hora","descripcion"},
     *              @OA\Property(property="idTrabajador", type="integer", example=101),
     *              @OA\Property(property="idInstalacion", type="integer", example=201),
     *              @OA\Property(property="hora", type="string", example="12:00"),
     *              @OA\Property(property="descripcion", type="string", example="Foco fundido")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Incidencia creada correctamente",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="success"),
     *              @OA\Property(property="message", type="string", example="Incidencia creada correctamente")
     *          )
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Error al crear la incidencia"
     *      )
     * )
     */
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

    /**
     * @OA\Put(
     *      path="/api/public/post/update/{id}",
     *      operationId="updateIncidencia",
     *      tags={"Incidencias"},
     *      summary="Actualizar una incidencia existente",
     *      description="Actualiza los datos de una incidencia existente basada en su ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la incidencia a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"idTrabajador","idInstalacion","hora","descripcion"},
     *              @OA\Property(property="idTrabajador", type="integer", example=101),
     *              @OA\Property(property="idInstalacion", type="integer", example=201),
     *              @OA\Property(property="hora", type="string", example="12:00"),
     *              @OA\Property(property="descripcion", type="string", example="Descripción actualizada")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Incidencia actualizada correctamente"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Incidencia no encontrada"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error al actualizar la incidencia"
     *      )
     * )
     */
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

    /**
     * @OA\Delete(
     *      path="/api/public/post/delete/{id}",
     *      operationId="deleteIncidencia",
     *      tags={"Incidencias"},
     *      summary="Eliminar una incidencia",
     *      description="Elimina de la base de datos una incidencia específica",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de la incidencia a eliminar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Incidencia eliminada correctamente"
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Incidencia no encontrada"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error al eliminar la incidencia"
     *      )
     * )
     */
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