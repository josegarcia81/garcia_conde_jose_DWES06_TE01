# Sistema de Gestión de Incidencias - Backend Laravel

## 📋 Descripción del Proyecto

Este proyecto implementa un **API REST controlador** desarrollado en Laravel que actúa como capa de validación y orquestación para un sistema de gestión de incidencias empresariales. El backend Laravel recibe peticiones HTTP desde clientes externos (como Postman), valida los datos recibidos y los reenvía a un microservicio Spring Boot que gestiona la persistencia de datos en MySQL.

### 🏗️ Arquitectura del Sistema

```
Cliente (Postman/Frontend) 
    ↓ HTTP Request
Laravel Backend (Puerto 8000)
    ├── Validación de datos
    ├── Control de peticiones
    └── Comunicación HTTP con Microservicio
        ↓ HTTP Request  
Spring Boot Microservicio (Puerto 8080)
    ├── Lógica de negocio
    ├── Gestión de base de datos MySQL
    └── Respuestas JSON
        ↓
Base de Datos MySQL (Incidencias)
```

## 🔄 Flujo de Comunicación

### Laravel → Spring Boot

El backend Laravel utiliza el **HTTP Client de Laravel** (`Illuminate\Support\Facades\Http`) para comunicarse con el microservicio Spring Boot:

1. **Recepción**: Laravel recibe la petición HTTP del cliente en las rutas definidas en `/routes/api.php`
2. **Validación**: El `PostController` valida los datos de entrada utilizando las reglas de validación de Laravel
3. **Reenvío**: Laravel realiza una petición HTTP al microservicio Spring Boot en `http://localhost:8080/spring/*`
4. **Procesamiento**: Spring Boot ejecuta las operaciones CRUD en la base de datos MySQL
5. **Respuesta**: Laravel recibe la respuesta del microservicio y la formatea antes de devolverla al cliente

### Ejemplo de Comunicación

```php
// Laravel realiza petición GET al microservicio
$response = Http::get('http://localhost:8080/spring/getAll');

// Laravel realiza petición POST con validación previa
$dataVal = $request->validate([...]);
$response = Http::post('http://localhost:8080/spring/create', $dataVal);

// Laravel realiza petición PUT
$response = Http::put('http://localhost:8080/spring/update/'.$id, $dataVal);

// Laravel realiza petición DELETE
$response = Http::delete('http://localhost:8080/spring/delete/'.$id);
```

## 🛠️ Tecnologías Utilizadas

| Tecnología | Versión | Propósito |
|-----------|---------|-----------|
| **PHP** | 8.2+ | Lenguaje base |
| **Laravel** | 12.0 | Framework PHP |
| **Laravel Sanctum** | 4.0 | Autenticación API |
| **MySQL** | 5.7+ | Base de datos |
| **Composer** | 2.x | Gestor de dependencias |

## 📂 Estructura del Proyecto

```
backend/my_api_rest/
├── app/
│   ├── Http/Controllers/
│   │   ├── PostController.php          # Controlador principal de incidencias
│   │   ├── TrabajadorController.php    # Controlador de trabajadores
│   │   └── InstalacionController.php   # Controlador de instalaciones
│   ├── Models/
│   │   ├── Incidencia.php
│   │   ├── Trabajador.php
│   │   └── Instalacion.php
│   └── DTO/
│       └── IncidenciasDTO.php
├── routes/
│   └── api.php                          # Definición de rutas API
├── config/
├── database/
│   └── migrations/                      # Migraciones de base de datos
└── .env.example                         # Plantilla de configuración
```

## 🚀 Instalación y Configuración

### Prerrequisitos

- PHP 8.2 o superior
- Composer
- MySQL Server
- Spring Boot Microservicio ejecutándose en puerto 8080

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/josegarcia81/garcia_conde_jose_DWES06_TE01.git
cd backend/my_api_rest
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar variables de entorno**
```bash
cp .env.example .env
```

Editar `.env` con la configuración de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=incidencias
DB_USERNAME=root
DB_PASSWORD=
```

4. **Generar clave de aplicación**
```bash
php artisan key:generate
```

5. **Ejecutar migraciones** (opcional, la base de datos se gestiona desde el microservicio)
```bash
php artisan migrate
```

6. **Iniciar servidor de desarrollo**
```bash
php artisan serve
```

El servidor estará disponible en `http://localhost:8000`

## 📡 Endpoints Disponibles

### Gestión de Incidencias

| Método | Endpoint | Descripción | Spring Boot Endpoint |
|--------|----------|-------------|----------------------|
| GET | `/api/public/post/get` | Obtener todas las incidencias | `GET /spring/getAll` |
| GET | `/api/public/post/get/{id}` | Obtener incidencia por ID | `GET /spring/getById/{id}` |
| POST | `/api/public/post/create` | Crear nueva incidencia | `POST /spring/create` |
| PUT | `/api/public/post/update/{id}` | Actualizar incidencia | `PUT /spring/update/{id}` |
| DELETE | `/api/public/post/delete/{id}` | Eliminar incidencia | `DELETE /spring/delete/{id}` |

### Formato de Petición (POST/PUT)

```json
{
    "idTrabajador": 101,
    "idInstalacion": 201,
    "hora": "12:00",
    "descripcion": "Descripción de la incidencia"
}
```

### Formato de Respuesta

```json
{
    "status": "success",
    "code": 200,
    "time": "2026-02-02T10:09:35+00:00",
    "message": "Base de datos con todas las incidencias",
    "data": [...]
}
```

## 🔐 Validación de Datos

Laravel valida todas las peticiones antes de reenviarlas al microservicio:

```php
$dataVal = $request->validate([
    'idTrabajador' => 'required|integer',
    'idInstalacion' => 'required|integer',
    'hora' => 'required|string',
    'descripcion' => 'required|string'
]);
```

## 🗄️ Modelo de Datos

### Incidencias
- `id`: ID único de la incidencia (autoincremental)
- `idTrabajador`: ID del trabajador que registra la incidencia
- `idInstalacion`: ID de la instalación afectada
- `hora`: Hora de la incidencia
- `descripcion`: Descripción detallada del problema

### Relaciones
- Una incidencia pertenece a **un trabajador**
- Una incidencia pertenece a **una instalación**
- Cascadas definidas: `ON UPDATE CASCADE`, `ON DELETE CASCADE` (instalaciones)

## 🧪 Pruebas

### Colección Postman

El proyecto incluye una colección completa de Postman ubicada en la raíz del proyecto:
- `garcia_conde_jose_DWES06_TE01_postman_collection.json`

### Testing con PHPUnit

```bash
php artisan test
```

## 🔗 Integración con Microservicio Spring Boot

El microservicio Spring Boot debe estar ejecutándose en `http://localhost:8080` con los siguientes endpoints disponibles:

- **GET** `/spring/getAll` - Devuelve todas las incidencias
- **GET** `/spring/getById/{id}` - Devuelve incidencia específica
- **POST** `/spring/create` - Crea nueva incidencia
- **PUT** `/spring/update/{id}` - Actualiza incidencia
- **DELETE** `/spring/delete/{id}` - Elimina incidencia

## ⚠️ Gestión de Errores

Laravel captura y maneja todos los errores de comunicación con el microservicio:

```php
try {
    $response = Http::get('http://localhost:8080/spring/getAll');
    // Respuesta exitosa
    return response()->json([...], 200);
} catch(\Exception $e) {
    // Error en comunicación
    return response()->json([
        "status" => "error",
        "code" => 500,
        "message" => "Ocurrió un error con la base de datos",
        "error" => $e->getMessage()
    ], 500);
}
```

## 📝 Base de Datos

La base de datos MySQL se crea utilizando el script SQL incluido en la raíz del proyecto:
- `Creacion_BD_y_tablas_Incidencias.sql`

Este script crea:
- Schema `incidencias`
- Tabla `trabajadores`
- Tabla `instalaciones`
- Tabla `incidencias`
- Datos de ejemplo
- Claves foráneas con reglas de cascada

## 👨‍💻 Autor

**José García Conde**  
Proyecto: DWES06_TE01

## 📄 Licencia

Este proyecto es parte de un trabajo académico.

---

**Nota**: Este backend actúa como controlador intermediario. La lógica de negocio y persistencia se encuentra en el microservicio Spring Boot.
