package birt.daw.apirest.dao;

import java.util.List;

import org.hibernate.Session;
import org.hibernate.query.Query;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Repository;
import org.springframework.transaction.annotation.Transactional;

import birt.daw.apirest.entity.Incidencia;
import jakarta.persistence.EntityManager;
import jakarta.persistence.EntityNotFoundException;

@Repository
public class IncidenciaDAOImp implements IncidenciaDAO {
	
	@Autowired
	private EntityManager entityManager;
	// Metodo que devuelve todas las incidencias de la BBDD //
	@Override
	@Transactional
	public List<Incidencia> getAll() {
		Session currentSession = entityManager.unwrap(Session.class);
		Query<Incidencia> consulta = currentSession.createQuery("from Incidencia", Incidencia.class);
		List<Incidencia> incidencias = consulta.getResultList();
		return incidencias;
	}
	// Metodo que devuelve una incidencia //
	@Override
	@Transactional
	public Incidencia getById(int id) {
		Session currentSession = entityManager.unwrap(Session.class);
		Incidencia incidencia = currentSession.get(Incidencia.class, id);
		return incidencia;
	}
	// Metodo que crea o actualiza una incidencia. Se usa el mismo metodo tanto para update como create //
	@Override
	@Transactional
	public Incidencia createOrUpdate(Incidencia incidencia, int id) {
		Session currentSession = entityManager.unwrap(Session.class);
		
		if(id != 0){
			Incidencia incidenciaFound = currentSession.find(Incidencia.class, id);
			if(incidenciaFound != null) {
				incidenciaFound.setDescripcion(incidencia.getDescripcion());
				incidenciaFound.setHora(incidencia.getHora());
				incidenciaFound.setIdInstalacion(incidencia.getIdInstalacion());
				incidenciaFound.setIdTrabajador(incidencia.getIdTrabajador());
				return incidenciaFound;
			} else {
				throw new EntityNotFoundException("Incidencia con ID " + id + " no encontrada.");
			}
		} else {
			currentSession.persist(incidencia);
	        return incidencia;
		}
	}
	// Metodo que borra una incidencia //
	@Override
	@Transactional
	public boolean delete(int id) {
		Session currentSession = entityManager.unwrap(Session.class);
		Incidencia incidencia = currentSession.find(Incidencia.class, id);
		if(incidencia != null) {
			currentSession.remove(incidencia);
			return true;
		} else {
			return false;
		}
			

	}

}
