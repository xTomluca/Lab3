CREATE TABLE proveedores(
    Numero int NOT NULL,
    Nombre varchar(30),
    Domicilio varchar(50),
    Localidad varchar(80),
    PRIMARY KEY(Numero))
    ENGINE = InnoDB;
	

CREATE TABLE productos(
    pNumero int NOT NULL,
    pNombre varchar(30),
    Precio float,
    Tamaño varchar(20),
    PRIMARY KEY(pNumero))
    ENGINE = InnoDB;

CREATE TABLE envios(
    Numero int NOT NULL,
    pNumero int NOT NULL,
    Cantidad int NOT NULL,
    PRIMARY KEY(Numero,pNumero))
    ENGINE = InnoDB;

INSERT INTO `envios`(`Numero`, `pNumero`, `Cantidad`) VALUES (100,1,500),(100,2,1500),(100,3,100),(101,2,55),(101,3,225),(102,1,600),(102,3,300);

INSERT INTO `productos`(`pNumero`, `pNombre`, `Precio`, `Tamaño`) VALUES (1,"Caramelos",1.5,"Chico"),(2,"Cigarrillos",45.89,"Mediano"),(3,"Gaseosa",15.80,"Grande");

INSERT INTO `proveedores`(`Numero`, `Nombre`, `Domicilio`, `Localidad`) VALUES (100,"Perez","P�ron 876","Quilmes"),(101,"Gimenez","Mitre 750","Avellaneda"),(102,"Aguirre","Boedo 634","Bernal");

SELECT * FROM `productos` ORDER BY`pNombre`ASC;

SELECT * FROM `proveedores` WHERE `Localidad`= "Quilmes";

SELECT * FROM `envios` WHERE `Cantidad` >=200 AND `Cantidad` <=300;

SELECT sum(Cantidad) cantidadTotalEnvios from envios;

SELECT pNumero FROM `envios` LIMIT 0,3;

SELECT prod.pNombre, prov.Nombre FROM envios as e, productos as prod, proveedores as prov WHERE e.pNumero = prod.pNumero and prov.Numero = e.Numero;

SELECT FORMAT(prod.Precio*e.Cantidad,2) totalCostoEnvios FROM productos as prod, envios as e WHERE e.pNumero = prod.pNumero;

SELECT sum(e.Cantidad) cantidadTotalEnviados FROM envios as e WHERE e.Numero = 102 and e.pNumero = 1;

SELECT e.pNumero Productos FROM envios as e, proveedores as prov WHERE prov.Numero = e.Numero and prov.Localidad = "Avellaneda";

SELECT prov.Localidad, prov.Domicilio FROM proveedores as prov WHERE prov.Nombre LIKE '%i%';

INSERT INTO `productos`(`pNumero`, `pNombre`, `Precio`, `Tamaño`) VALUES (4,"Cholocate",25.35,"Chico");

INSERT INTO proveedores(Numero) VALUES(103);

INSERT INTO proveedores(Numero,Nombre,Localidad) VALUES(107,"Rosales","La Plata");

UPDATE productos SET Precio= 97.50 WHERE Tamaño = "Grande";

UPDATE `productos`, `envios` SET `Tamaño`="Mediano" WHERE envios.Cantidad >=300 and productos.pNumero = envios.pNumero and productos.Tamaño ="Chico";

DELETE FROM `productos` WHERE productos.pNumero = 1;

DELETE FROM `proveedores` WHERE proveedores.Numero not in(SELECT envios.Numero FROM envios);


