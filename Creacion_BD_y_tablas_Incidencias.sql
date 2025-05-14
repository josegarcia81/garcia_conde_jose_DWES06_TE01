/*
CREATE SCHEMA `incidencias` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
*/
-- SELECT DATABASE('incidencias');

CREATE SCHEMA IF NOT EXISTS incidencias DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
USE incidencias;

DROP TABLE IF EXISTS incidencias;
DROP TABLE IF EXISTS trabajadores;
DROP TABLE IF EXISTS instalaciones;


CREATE TABLE trabajadores(
    idTrabajador int(6) NOT NULL,
    nombreTrabajador varchar(20),
    apellido1 varchar(20),
    apellido2 varchar(20),
    dni varchar(9),
    telefono varchar(20),
    direccion varchar(100),
    email varchar(20),
    
    PRIMARY KEY (idTrabajador)
)ENGINE=INNODB DEFAULT CHARSET=latin1;

CREATE TABLE instalaciones(
	idInstalacion int(6) NOT NULL,
    nombreInstalacion varchar(20),
    zona varchar(20),
    descripcionIns varchar(100),
    
    PRIMARY KEY (idInstalacion)
)ENGINE=INNODB DEFAULT CHARSET=latin1;

CREATE TABLE incidencias(
	id int(6) NOT NULL,
    id_Trabajador int(6) NOT NULL,
    id_Instalacion int(6) NOT NULL,
    hora varchar(5),
    descripcion varchar(100),
    
    PRIMARY KEY (id)
)ENGINE=INNODB DEFAULT CHARSET=latin1;

-- insercion de datos tabla TRABAJADORES
INSERT INTO trabajadores (idTrabajador, nombreTrabajador, apellido1, apellido2, dni, telefono, direccion, email) VALUES
(101, 'Txema', 'Martínez', 'García', '12345678A', '600123456', 'Calle Mayor, 1, Madrid', 'txema@mail.com'),
(102, 'Juan', 'López', 'Pérez', '23456789B', '610987654', 'Avenida del Sol, 5, Sevilla', 'juan@mail.com'),
(103, 'Pedro', 'Sánchez', 'Díaz', '34567890C', '620654321', 'Plaza España, 10, Valencia', 'pedro@mail.com');

-- insersion de datos tabla INSTALACIONES
INSERT INTO instalaciones (idInstalacion, nombreInstalacion, zona, descripcionIns) VALUES
(201, 'Maduración', 'Zona A', 'Área destinada al proceso de maduración de materiales.'),
(202, 'Recepción', 'Zona B', 'Zona de entrada de materiales.'),
(203, 'Biometanización', 'Zona C', 'Planta encargada de la producción de biogás.'),
(204, 'Trincheras', 'Zona D', 'Sector de almacenamiento y tratamiento intermedio.'),
(205, 'Pretratamiento', 'Zona E', 'Área de preprocesamiento, separacion y valorizacion de materiales.'),
(206, 'Prensa Rechazos', 'Zona F', 'Zona destinada al prensado de materiales no reutilizables con destino vertedero.'),
(207, 'Exteriores', 'Zona G', 'Área exterior utilizada para transito de camiones, mantenimiento y operaciones auxiliares.');

-- introduccion de datos tabla INCIDENCIAS
INSERT INTO incidencias (id, id_Trabajador, id_Instalacion, hora, descripcion) VALUES
(1, 101, 201, '12:00', 'foco fundido'),
(2, 102, 202, '12:30', 'puerta entrada rota'),
(3, 101, 203, '13:00', 'Cilindro r4 roto'),
(4, 101, 204, '09:30', 'cinta rodillo roto'),
(5, 103, 205, '23:00', 'cinta 106 babero roto'),
(6, 102, 206, '17:00', 'aguja rota'),
(7, 101, 207, '03:00', 'foco fundido parking');

-- Reglas Claves Foraneas
 ALTER TABLE incidencias
 	ADD CONSTRAINT Fk_Inc_Trabajador 
    FOREIGN KEY (id_Trabajador) 
    REFERENCES trabajadores(idTrabajador) ON UPDATE CASCADE;

 ALTER TABLE incidencias
	ADD CONSTRAINT Fk_Inc_Instalacion 
    FOREIGN KEY (id_Instalacion) 
    REFERENCES instalaciones(idInstalacion) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE incidencias 
	MODIFY COLUMN id BIGINT AUTO_INCREMENT;

select * from incidencias;
select * from trabajadores;
select * from instalaciones;

select * from incidencias
	join trabajadores on incidencias.id_Trabajador = trabajadores.idTrabajador
    join instalaciones on incidencias.id_Instalacion = instalaciones.idInstalacion;
    
-- Pruebas de las reglas update y delete en cascada de tabla incidencias
-- UPDATE trabajadores SET idTrabajador=104 WHERE idTrabajador=103;
-- UPDATE instalaciones SET idInstalacion=208 WHERE idInstalacion=207;
-- DELETE FROM instalaciones WHERE idInstalacion=208;
-- DELETE FROM incidencias WHERE idIncidencia=8;
-- commit