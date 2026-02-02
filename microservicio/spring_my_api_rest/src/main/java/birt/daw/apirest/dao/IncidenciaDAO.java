package birt.daw.apirest.dao;

import java.util.List;

import birt.daw.apirest.entity.Incidencia;

/**
 * Interfaz de acceso a datos (DAO) para la entidad Incidencia.
 * Define las operaciones CRUD básicas que deben ser implementadas.
 */
public interface IncidenciaDAO {
	
	/**
	 * Recupera todas las incidencias almacenadas.
	 * @return List&lt;Incidencia&gt; Lista completa de incidencias.
	 */
	public List<Incidencia> getAll();
	
	/**
	 * Busca una incidencia por su ID.
	 * @param id Identificador único de la incidencia.
	 * @return Incidencia Objeto encontrado o null si no existe.
	 */
	public Incidencia getById(int id);
	
	/**
	 * Guarda una nueva incidencia o actualiza una existente.
	 * @param incidencia Objeto con los datos a persistir.
	 * @param id ID de la incidencia (usado para actualizaciones).
	 * @return Incidencia Objeto guardado con su ID actualizado.
	 */
	public Incidencia createOrUpdate(Incidencia incidencia, int id);
	
	/**
	 * Elimina una incidencia por su ID.
	 * @param id Identificador de la incidencia a borrar.
	 * @return boolean true si se eliminó correctamente, false si no se encontró.
	 */
	public boolean delete(int id);

}
