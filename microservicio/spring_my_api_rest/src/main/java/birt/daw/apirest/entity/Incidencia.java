package birt.daw.apirest.entity;

import org.hibernate.annotations.DynamicUpdate;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;

@Entity
@DynamicUpdate
@Table(name="incidencias")
public class Incidencia {

	@Id
	@GeneratedValue(strategy=GenerationType.IDENTITY)
	@Column(name="id")
	private int id;
	
	@Column(name="idTrabajador")
	private int idTrabajador;

	// Relación con la tabla Instalaciones (clave foránea)
    // @ManyToOne(cascade = CascadeType.ALL)  // Propaga las operaciones a la instalación
    // @JoinColumn(name = "idInstalacion", referencedColumnName = "idInstalacion")
	@Column(name="idInstalacion")
	private int idInstalacion;
	
	@Column(name="hora")
	private String hora;
	
	@Column(name="descripcion")
	private String descripcion;

	public Incidencia() {
		// Constructor por defecto requerido por JPA
	}

	// Constructor
	public Incidencia(int id, int idTrabajador, int idInstalacion, String hora, String descripcion) {
		super();
		this.id = id;
		this.idTrabajador = idTrabajador;
		this.idInstalacion = idInstalacion;
		this.hora = hora;
		this.descripcion = descripcion;
	}
	
	// Getters y setters

	public int getId() {
		return id;
	}

	public void setId(int id) {
		this.id = id;
	}

	public int getIdTrabajador() {
		return idTrabajador;
	}

	public void setIdTrabajador(int idTrabajador) {
		this.idTrabajador = idTrabajador;
	}

	public int getIdInstalacion() {
		return idInstalacion;
	}

	public void setIdInstalacion(int idInstalacion) {
		this.idInstalacion = idInstalacion;
	}

	public String getHora() {
		return hora;
	}

	public void setHora(String hora) {
		this.hora = hora;
	}

	public String getDescripcion() {
		return descripcion;
	}

	public void setDescripcion(String descripcion) {
		this.descripcion = descripcion;
	}
	
	
	
}