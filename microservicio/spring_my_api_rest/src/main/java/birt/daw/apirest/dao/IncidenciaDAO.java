package birt.daw.apirest.dao;

import java.util.List;

import birt.daw.apirest.entity.Incidencia;

public interface IncidenciaDAO {
	
	public List<Incidencia> getAll();
	
	public Incidencia getById(int id);
	
	public Incidencia createOrUpdate(Incidencia incidencia, int id);
	
	public boolean delete(int id);

}
