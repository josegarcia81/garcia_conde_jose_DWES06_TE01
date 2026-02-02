# Sistema de Gestión de Incidencias - Microservicio Spring Boot

## 📋 Descripción del Proyecto

Este proyecto es un **Microservicio RESTful** desarrollado con **Spring Boot** que gestiona la lógica de negocio y la persistencia de datos del sistema de gestión de incidencias. Actúa como el núcleo de datos, recibiendo peticiones validadas desde el backend Laravel y ejecutando operaciones CRUD directamente sobre la base de datos MySQL.

### 🏗️ Arquitectura del Sistema

```
Laravel Backend (Controlador) 
    ↓ HTTP Request
Spring Boot Microservicio (Puerto 8080)
    ├── API REST Controller
    ├── Capa de Servicio (Lógica de Negocio)
    ├── Repositorio JPA (Hibernate)
    └── Gestión de Transacciones
        ↓ SQL
Base de Datos MySQL (Schema: incidencias)
```

## 🔄 Responsabilidades

A diferencia del backend Laravel que actúa como "puerta de enlace" y validador, este microservicio es responsable de:

1. **Persistencia**: Guardar, recuperar, actualizar y eliminar registros de incidencias.
2. **Integridad de Datos**: Asegurar que los datos se almacenen correctamente en las tablas relacionales.
3. **Respuesta Estructurada**: Devolver objetos JSON puros que serán consumidos por el controlador Laravel.

## 🛠️ Tecnologías Utilizadas

| Tecnología | Versión | Propósito |
|-----------|---------|-----------|
| **Java** | 17 | Lenguaje de programación |
| **Spring Boot** | 3.4.5 | Framework principal |
| **Spring Data JPA** | - | Abstracción de acceso a datos |
| **Hibernate** | - | ORM (Object-Relational Mapping) |
| **MySQL Connector** | - | Driver JDBC |
| **Maven** | 3.x | Gestor de dependencias |

## 📂 Estructura del Proyecto

```
microservicio/spring_my_api_rest/
├── src/
│   ├── main/
│   │   ├── java/birt/daw/apirest/
│   │   │   ├── controller/
│   │   │   │   └── ControllerIncidencia.java  # Endpoints REST
│   │   │   ├── service/
│   │   │   │   ├── ServicioIncidencia.java    # Interfaz de servicio
│   │   │   │   └── ServicioIncidenciaImp.java # Implementación lógica
│   │   │   ├── dao/
│   │   │   │   └── IncidenciaDAO.java         # Repositorio (Data Access Object)
│   │   │   ├── entity/
│   │   │   │   └── Incidencia.java            # Entidad JPA
│   │   │   └── SpringMyApiRestApplication.java # Clase principal
│   │   └── resources/
│   │       └── application.properties         # Configuración (BD, Puerto)
└── pom.xml                                    # Dependencias Maven
```

## 🚀 Instalación y Ejecución

### Prerrequisitos

- JDK 17 o superior
- Maven (o usar `mvnw` incluido)
- MySQL Server ejecutándose

### Pasos de Instalación

1. **Navegar al directorio del proyecto**
```bash
cd microservicio/spring_my_api_rest
```

2. **Configurar Base de Datos**
Asegúrate de que el archivo `src/main/resources/application.properties` apunta a tu base de datos MySQL local:

```properties
spring.datasource.url=jdbc:mysql://127.0.0.1:3306/incidencias
spring.datasource.username=root
spring.datasource.password=
spring.jpa.show-sql=true
```

3. **Ejecutar la aplicación**
Utilizando el wrapper de Maven incluido:

```bash
./mvnw spring-boot:run
```

O si tienes Maven instalado globalmente:
```bash
mvn spring-boot:run
```

El servidor iniciará en el puerto **8080** por defecto.

## 📡 Endpoints API REST

Este microservicio expone los siguientes endpoints bajo el prefijo `/spring`. Estos endpoints están diseñados para ser consumidos internamente por el backend Laravel.

| Método | Endpoint | Descripción | Body Requerido |
|--------|----------|-------------|----------------|
| GET | `/spring/getAll` | Lista todas las incidencias | No |
| GET | `/spring/getById/{id}` | Busca una incidencia por ID | No |
| POST | `/spring/create` | Crea una nueva incidencia | JSON Incidencia |
| PUT | `/spring/update/{id}` | Actualiza una incidencia existente | JSON Incidencia |
| DELETE | `/spring/delete/{id}` | Elimina una incidencia | No |

### Ejemplo de Body (JSON)

Para las operaciones POST y PUT:

```json
{
    "idTrabajador": 101,
    "idInstalacion": 201,
    "hora": "12:00",
    "descripcion": "Descripción detallada de la avería o incidencia"
}
```

## 🗄️ Modelo de Datos (Entidad JPA)

La clase `Incidencia` mapea directamente a la tabla `incidencias` de la base de datos.

```java
@Entity
@Table(name="incidencias")
public class Incidencia {
    @Id
    @GeneratedValue(strategy=GenerationType.IDENTITY)
    private int id;
    
    @Column(name="idTrabajador")
    private int idTrabajador;   // FK lógica a tabla trabajadores
    
    @Column(name="idInstalacion")
    private int idInstalacion;  // FK lógica a tabla instalaciones
    
    @Column(name="hora")
    private String hora;
    
    @Column(name="descripcion")
    private String descripcion;
    
    // Getters, Setters y Constructores...
}
```

*Nota: Las relaciones con `Trabajador` e `Instalacion` se gestionan mediante IDs (`idTrabajador`, `idInstalacion`) para simplificar la persistencia y mantener el microservicio ligero, delegando la integridad referencial a la base de datos MySQL.*

## ⚠️ Gestión de Errores

El controlador maneja excepciones comunes para devolver respuestas HTTP adecuadas:

- **404 Not Found**: Cuando se busca una incidencia que no existe (`getById`, `update`).
- **500 Internal Server Error**: Para errores generales o de base de datos.

## 👨‍💻 Autor

**José García Conde**  
Proyecto: DWES06_TE01

## 📄 Licencia

Este proyecto es parte de un trabajo académico.
