# DWES06
## Laravel backend controller and SpringBoot backend microservice controller.

## BACKEND LARAVEL

- La primera carpeta contiene un proyecto en framework Laravel que recibira las peticiones Http de la coleccion de Postman y validara y controlara estas, haciendo despues las peticiones Http correspondientes a el proyecto SpringBoot.
- Estas peticiones seran de tipo CRUD(create, read, update, delete) En la coleccion Postman se encuentran todos los detalles de las mismas.

## MICROSERVICIO SPRINGBOOT

- Este microservicio en framework SpringBoot recibira las peticiones Http de el backend Laravel y se encargara de gestionar la base de datos, que almacena incidencias registradas por una empresa, en funcion de las mismas.
- Devolvera los datos o los posibles errores en formato json para su posterior control en el backend.