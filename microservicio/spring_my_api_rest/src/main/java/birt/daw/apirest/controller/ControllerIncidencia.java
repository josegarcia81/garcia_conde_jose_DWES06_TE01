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

@RestController
@RequestMapping("/spring")
public class ControllerIncidencia {
	
	@Autowired
	private ServicioIncidencia servicioIncidencia;
	
	@GetMapping("/getAll")
	public List<Incidencia> getAll(){
		return servicioIncidencia.getAll();
	}
	
	@GetMapping("/getById/{id}")
	public Incidencia getById(@PathVariable int id) {
		Incidencia incidencia = servicioIncidencia.getById(id);
		
		if (incidencia == null) {
			throw new ResponseStatusException(HttpStatus.NOT_FOUND, "No existe la incidencia con ID: " + id);
		}
		return incidencia;
	}
	
	@PostMapping("/create")
	public ResponseEntity<Incidencia> create(@RequestBody Incidencia incidencia) {
		//incidencia.setId(0);
		int id=0;
		
		Incidencia nuevaIncidencia = servicioIncidencia.createOrUpdate(incidencia, id);
		
		return ResponseEntity.status(HttpStatus.CREATED).body(nuevaIncidencia);
	}
	
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
