CREATE DATABASE market;
USE market;

CREATE TABLE `market`.`usuarios` (
  `usuarioid` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(50) NOT NULL,
  `pass` VARCHAR(300) NOT NULL,
  `nombres` VARCHAR(100) NOT NULL,
  `apellidos` VARCHAR(100) NOT NULL,
  `telefono` VARCHAR(14) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `fecha_registro` DATE NOT NULL,
  `rol` INT NOT NULL,
  PRIMARY KEY (`usuarioid`),
  UNIQUE INDEX `usuarioid_UNIQUE` (`usuarioid` ASC),
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC),
  UNIQUE INDEX `correo_UNIQUE` (`correo` ASC),
  UNIQUE INDEX `telefono_UNIQUE` (`telefono` ASC));

CREATE TABLE `market`.`rol` (
  `rolid` INT NOT NULL AUTO_INCREMENT,
  `nombrerol` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`rolid`));

INSERT INTO `market`.`rol`
  (`rolid`,`nombrerol`)VALUES (1,'usuario');
INSERT INTO `market`.`rol`
  (`rolid`,`nombrerol`)VALUES (2,'capturista');
INSERT INTO `market`.`rol`
  (`rolid`,`nombrerol`)VALUES (3,'administrador');

ALTER TABLE usuarios
  ADD CONSTRAINT fk_rol
  FOREIGN KEY (rol) 
  REFERENCES rol(rolid)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

CREATE TABLE `market`.`categorias` (
  `categoriaid` INT NOT NULL AUTO_INCREMENT,
  `nombrecat` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`categoriaid`),
  UNIQUE INDEX `nombrecat_UNIQUE` (`nombrecat` ASC));

INSERT INTO `market`.`categorias`
  (`categoriaid`,`nombrecat`)VALUES (1,'Sudaderas');
  INSERT INTO `market`.`categorias`
  (`categoriaid`,`nombrecat`)VALUES (2,'Playeras');
  INSERT INTO `market`.`categorias`
  (`categoriaid`,`nombrecat`)VALUES (3,'Gorras');
  INSERT INTO `market`.`categorias`
  (`categoriaid`,`nombrecat`)VALUES (4,'Lentes');
  INSERT INTO `market`.`categorias`
  (`categoriaid`,`nombrecat`)VALUES (5,'Pantalones');

  CREATE TABLE `market`.`colores` (
  `colorid` INT NOT NULL AUTO_INCREMENT,
  `nombrecolor` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`colorid`),
  UNIQUE INDEX `nombrecolor_UNIQUE` (`nombrecolor` ASC));


  INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (1,'Negro');
  INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (2,'Blanco');
  INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (3,'Azul');
  INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (4,'Amarillo');
  INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (5,'Rosa');
    INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (6,'Verde');
  INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (7,'Naranja');
    INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (8,'Cafe');
  INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (9,'Morado');
    INSERT INTO `market`.`colores`
  (`colorid`,`nombrecolor`)VALUES (10,'Rojo');

  CREATE TABLE `market`.`tallas` (
  `tallaid` INT NOT NULL AUTO_INCREMENT,
  `nombretalla` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`tallaid`),
  UNIQUE INDEX `nombretalla_UNIQUE` (`nombretalla` ASC));

  INSERT INTO `market`.`tallas`
  (`tallaid`,`nombretalla`)VALUES (1,'S');
  INSERT INTO `market`.`tallas`
  (`tallaid`,`nombretalla`)VALUES (2,'M');
  INSERT INTO `market`.`tallas`
  (`tallaid`,`nombretalla`)VALUES (3,'L');
  INSERT INTO `market`.`tallas`
  (`tallaid`,`nombretalla`)VALUES (4,'XL');
  INSERT INTO `market`.`tallas`
  (`tallaid`,`nombretalla`)VALUES (5,'Unitalla');
  
  CREATE TABLE `market`.`articulos` (
  `articuloid` INT NOT NULL AUTO_INCREMENT,
  `codigo` VARCHAR(50) NOT NULL,
  `nombreart` VARCHAR(100) NOT NULL,
  `categoriafk` INT NOT NULL,
  `estado` TINYINT NOT NULL,
  `precio_original` DECIMAL(7,2) NOT NULL,
  `precio_venta` DECIMAL(7,2) NOT NULL,
  `cantidad` INT NOT NULL,
  `descripcion` VARCHAR(300) NOT NULL,
  `talla` INT NOT NULL,
  `color` INT NOT NULL,
  `imagen` INT NULL,
  `fecha_cambios` DATE NOT NULL,
  `fecha_registro` DATE NOT NULL,
  PRIMARY KEY (`articuloid`),
  UNIQUE INDEX `articuloid_UNIQUE` (`articuloid` ASC),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC),
  INDEX `categoriafk_idx` (`categoriafk` ASC),
  INDEX `talla_fk_idx` (`talla` ASC),
  INDEX `color_fk_idx` (`color` ASC),
  CONSTRAINT `categoria_fk`
    FOREIGN KEY (`categoriafk`)
    REFERENCES `market`.`categorias` (`categoriaid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `talla_fk`
    FOREIGN KEY (`talla`)
    REFERENCES `market`.`tallas` (`tallaid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `color_fk`
    FOREIGN KEY (`color`)
    REFERENCES `market`.`colores` (`colorid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE `orden_estado` (
  `ordenestadoid` int(11) NOT NULL AUTO_INCREMENT,
  `nombreestado` varchar(20) NOT NULL,
  PRIMARY KEY (`ordenestadoid`),
  UNIQUE KEY `nombreestado_UNIQUE` (`nombreestado`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

    INSERT INTO `market`.`orden_estado` (`nombreestado`) VALUES('ENVIADO');
    INSERT INTO `market`.`orden_estado` (`nombreestado`) VALUES('PAGADO');
    INSERT INTO `market`.`orden_estado` (`nombreestado`) VALUES('PENDIENTE');
    INSERT INTO `market`.`orden_estado` (`nombreestado`) VALUES('CANCELADO');


CREATE TABLE `orden` (
  `ordenid` int(11) NOT NULL AUTO_INCREMENT,
  `envio` decimal(7,2) NOT NULL DEFAULT '89.00',
  `subtotal` decimal(7,2) NOT NULL DEFAULT '0.00',
  `total` decimal(7,2) GENERATED ALWAYS AS ((`envio` + `subtotal`)) VIRTUAL,
  `estado` int(11) NOT NULL DEFAULT '3',
  `usuarioid` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`ordenid`),
  KEY `usuario_idx` (`usuarioid`),
  KEY `estadoid_idx` (`estado`),
  CONSTRAINT `estadoid` FOREIGN KEY (`estado`) REFERENCES `orden_estado` (`ordenestadoid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usuarioid` FOREIGN KEY (`usuarioid`) REFERENCES `usuarios` (`usuarioid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `orden_articulos` (
  `ordenarticulosid` int(11) NOT NULL AUTO_INCREMENT,
  `ordenid` int(11) NOT NULL,
  `articuloid` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(7,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`ordenarticulosid`),
  KEY `articuloid_idx` (`articuloid`),
  KEY `ordenid_idx` (`ordenid`),
  CONSTRAINT `articuloid` FOREIGN KEY (`articuloid`) REFERENCES `articulos` (`articuloid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `ordenid` FOREIGN KEY (`ordenid`) REFERENCES `orden` (`ordenid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE VIEW info_orden AS
SELECT c.ordenid,    a.nombreart,    a.articuloid,    c.precio,    c.cantidad,    l.usuarioid    
FROM    articulos a	JOIN    orden_articulos c ON a.articuloid = c.articuloid
JOIN orden AS l	ON l.ordenid = c.ordenid;

-- ESTE EVENTO CANCELA LAS ORDENES DESPUES DE 5 DIAS QUE ESTEN PENDIENTES

SET GLOBAL event_scheduler = ON;

DELIMITER $$
CREATE EVENT cancelacion_5_dias    ON SCHEDULE
EVERY 1 MINUTE   
DO  
BEGIN
UPDATE `market`.`orden` SET `estado` = '4' WHERE `estado` = '3'
AND UNIX_TIMESTAMP(`fecha`) < (UNIX_TIMESTAMP()-5*86400); 
END$$

DELIMITER ;

-- ESTE PROCEDURE REALIZA LA CANCELACION DE ORDEN
DELIMITER //
DROP PROCEDURE IF EXISTS cancelacion //
CREATE PROCEDURE cancelacion(pordenid int)
BEGIN  
   -- Declaramos las variables necesarias 
   -- La primera para saber cuando se detendra la consulta
   DECLARE done INT DEFAULT FALSE;
   -- Esta variable son las que recibiran los elementos necesarios 
   DECLARE particuloid int DEFAULT 0;
   DECLARE pcantidad int DEFAULT 0;

   -- Recorre se llma la variable CURSOR que recorre en base a la consulta
   DECLARE recorre CURSOR FOR
      SELECT articuloid, cantidad FROM orden_articulos WHERE ordenid=pordenid;
      
   -- Se declara un manejador para saber cuando se tiene que detener 
   DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
   -- Se abre el cursor
   OPEN recorre;
   loop_recorre: LOOP   
       FETCH recorre INTO particuloid,pcantidad;
       -- Fetch lo utilizamos para leer cada uno de los registros
       -- If que permite salir del ciclo
       IF done THEN 
   LEAVE loop_recorre;
    END IF;
    -- actualizamos los articulos
		 UPDATE articulos SET cantidad = cantidad + pcantidad WHERE articuloid = particuloid;
	END LOOP;
   -- cerramos el cursor 
   CLOSE recorre;
  
END//

DELIMITER ;
-- ESTE TRIGGER CANCELA LA ORDEN
DELIMITER $$
CREATE TRIGGER cancelacion_orden_trigger
    AFTER UPDATE
    ON orden FOR EACH ROW
BEGIN
    IF new.estado = 4 THEN
	call cancelacion(new.ordenid);
    END IF;
END$$

DELIMITER ;

-- ESTE TRIGGER EVITA QUE SE VUELVA A CANCELAR LA ORDEN
DELIMITER $$
CREATE TRIGGER cancelacion_prevencion_orden_trigger
    AFTER UPDATE
    ON orden FOR EACH ROW
BEGIN
    IF old.estado = 4 THEN
	UPDATE `market`.`orden` SET `estado` = '4' WHERE ordenid = old.ordenid ;
    END IF;
END$$
DELIMITER ;