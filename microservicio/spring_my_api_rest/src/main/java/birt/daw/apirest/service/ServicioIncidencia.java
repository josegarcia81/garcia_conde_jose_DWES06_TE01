package birt.daw.apirest.service;

import java.util.List;

import birt.daw.apirest.entity.Incidencia;

/**
 * Interfaz de servicio para la lógica de negocio de Incidencias.
 * Actúa como intermediario entre el controlador y la capa de datos (DAO).
 */
public interface ServicioIncidencia {
	
	/**
	 * Obtiene el listado de todas las incidencias.
	 * @return List&lt;Incidencia&gt; Lista de incidencias.
	 */
	public List<Incidencia> getAll();
	
	/**
	 * Recupera una incidencia específica por su identificador.
	 * @param id ID de la incidencia.
	 * @return Incidencia La incidencia encontrada.
	 */
	public Incidencia getById(int id);
	
	/**
	 * Crea o actualiza una incidencia en el sistema.
	 * @param incidencia Datos de la incidencia.
	 * @param id ID de la incidencia (0 para creación).
	 * @return Incidencia La incidencia persistida.
	 */
	public Incidencia createOrUpdate(Incidencia incidencia, int id);
	
	/**
	 * Elimina una incidencia del sistema.
	 * @param id ID de la incidencia a eliminar.
	 * @return boolean true si la operación fue exitosa.
	 */
	public boolean delete(int id);

}
