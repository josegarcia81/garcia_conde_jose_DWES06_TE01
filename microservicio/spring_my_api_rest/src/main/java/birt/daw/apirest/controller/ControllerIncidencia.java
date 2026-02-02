package birt.daw.apirest.controller;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.server.ResponseStatusException;

import birt.daw.apirest.entity.Incidencia;
import birt.daw.apirest.service.ServicioIncidencia;
import jakarta.persistence.EntityNotFoundException;

/**
 * Controlador REST para la gestión de incidencias.
 * <p>
 * Este controlador expone una API REST bajo la ruta base "/spring" para realizar
 * operaciones CRUD sobre la entidad {@link Incidencia}. Está diseñado para ser consumido
 * por el backend Laravel.
 * </p>
 *
 * @author Jose Garcia Conde
 * @version 1.0
 */
@RestController
@RequestMapping("/spring")
public class ControllerIncidencia {
	
	@Autowired
	private ServicioIncidencia servicioIncidencia;
	
	/**
	 * Obtiene el listado completo de todas las incidencias registradas.
	 *
	 * @return List&lt;Incidencia&gt; Lista de objetos Incidencia encontrados en la base de datos.
	 *         Devuelve una lista vacía si no hay registros.
	 */
	@GetMapping("/getAll")
	public List<Incidencia> getAll(){
		return servicioIncidencia.getAll();
	}
	
	/**
	 * Busca una incidencia específica por su identificador único.
	 *
	 * @param id El ID de la incidencia a buscar.
	 * @return Incidencia El objeto encontrado.
	 * @throws ResponseStatusException Si no se encuentra ninguna incidencia con el ID proporcionado (HTTP 404).
	 */
	@GetMapping("/getById/{id}")
	public Incidencia getById(@PathVariable int id) {
		Incidencia incidencia = servicioIncidencia.getById(id);
		
		if (incidencia == null) {
			throw new ResponseStatusException(HttpStatus.NOT_FOUND, "No existe la incidencia con ID: " + id);
		}
		return incidencia;
	}
	
	/**
	 * Crea un nuevo registro de incidencia en la base de datos.
	 *
	 * @param incidencia Objeto {@link Incidencia} con los datos a persistir (idTrabajador, idInstalacion, hora, descripcion).
	 * @return ResponseEntity&lt;Incidencia&gt; Respuesta HTTP 201 (Created) con el objeto guardado, incluyendo su nuevo ID.
	 */
	@PostMapping("/create")
	public ResponseEntity<Incidencia> create(@RequestBody Incidencia incidencia) {
		//incidencia.setId(0);
		int id=0;
		
		Incidencia nuevaIncidencia = servicioIncidencia.createOrUpdate(incidencia, id);
		
		return ResponseEntity.status(HttpStatus.CREATED).body(nuevaIncidencia);
	}
	
	/**
	 * Actualiza los datos de una incidencia existente.
	 *
	 * @param incidencia Objeto {@link Incidencia} con los nuevos datos.
	 * @param id El ID de la incidencia que se desea modificar.
	 * @return ResponseEntity&lt;?&gt; Respuesta HTTP 200 (OK) con la incidencia actualizada,
	 *         o HTTP 404 (Not Found) si no existe el registro.
	 *         En caso de error interno, devuelve HTTP 500.
	 */
	@PutMapping("/update/{id}")
	public ResponseEntity<?> update(@RequestBody Incidencia incidencia, @PathVariable int id) {
		
		try {
	        incidencia.setId(id);
	        Incidencia actualizada = servicioIncidencia.createOrUpdate(incidencia, id);
	        
	        if (actualizada == null) {
	            return ResponseEntity.status(HttpStatus.NOT_FOUND).body(Map.of("Incidencia no encontrada", "id"));
	        }
	        
	        return ResponseEntity.ok(actualizada);
	    } catch (EntityNotFoundException e) {
	        return ResponseEntity.status(HttpStatus.NOT_FOUND).body(Map.of("error", "Incidencia no encontrada", "id", id));
	    } catch (Exception e) {
	        return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body(Map.of("message", e.getMessage()));
	    }
	}
	
	/**
	 * Elimina una incidencia de la base de datos.
	 *
	 * @param id El ID de la incidencia a eliminar.
	 * @return ResponseEntity&lt;?&gt; Respuesta HTTP 200 con mensaje de éxito si se elimina correctamente,
	 *         o HTTP 404 si el ID no existe.
	 *         Puede devolver HTTP 500 si ocurre un error durante el proceso.
	 */
	@DeleteMapping("/delete/{id}")
	public ResponseEntity<?> delete(@PathVariable int id) {
		try {
			boolean deleted = servicioIncidencia.delete(id);
			if (deleted) {
				return ResponseEntity.ok("Incidencia eliminada");
			}
			return ResponseEntity.status(HttpStatus.NOT_FOUND).body("No se encontró la incidencia con ID: " + id);
		} catch (Exception e){
			return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("Error interno: " + e.getMessage());
		}
	}
}
