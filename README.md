# DWES06
## Laravel backend controller and SpringBoot backend microservice controller.

## BACKEND LARAVEL

- La primera carpeta contiene un proyecto en framework Laravel que recibirá las peticiones Http de la colección de Postman y validará y controlará éstas, haciendo después las peticiones Http correspondientes a el proyecto SpringBoot.
- Estas peticiones serán de tipo CRUD(create, read, update, delete) En la colección Postman se encuentran todos los detalles de las mismas.

## MICROSERVICIO SPRINGBOOT

- Este microservicio en framework SpringBoot recibirá las peticiones Http de el backend Laravel y se encargará de gestionar la base de datos, que almacena incidencias registradas por una empresa, en funcion de las mismas.
- Devolverá los datos o los posibles errores en formato json para su posterior control en el backend.