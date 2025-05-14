package birt.daw.apirest.service;

import java.util.List;

import birt.daw.apirest.entity.Incidencia;

public interface ServicioIncidencia {
	
	public List<Incidencia> getAll();
	
	public Incidencia getById(int id);
	
	public Incidencia createOrUpdate(Incidencia incidencia, int id);
	
	public boolean delete(int id);

}
