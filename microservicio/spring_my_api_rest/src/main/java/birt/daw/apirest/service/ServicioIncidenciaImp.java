package birt.daw.apirest.service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import birt.daw.apirest.dao.IncidenciaDAO;
import birt.daw.apirest.entity.Incidencia;


@Service
public class ServicioIncidenciaImp implements ServicioIncidencia {

	@Autowired
	private IncidenciaDAO incidenciaDAO;
	
	@Override
	public List<Incidencia> getAll() {
		List<Incidencia> incidencias = incidenciaDAO.getAll();
		return incidencias;
	}

	@Override
	public Incidencia getById(int id) {
		Incidencia incidencia = incidenciaDAO.getById(id);
		return incidencia;
	}

	@Override
	public Incidencia createOrUpdate(Incidencia incidencia, int id) {
		
		return incidenciaDAO.createOrUpdate(incidencia, id);

	}

	@Override
	public boolean delete(int id) {
		return incidenciaDAO.delete(id);

	}

}
