create table marcas(
    id_marca int primary key auto_increment,
    nombre varchar(40) not null,
    provincia varchar(60),
    imagen varchar(60) default "./img/default.jpg"
);
insert into marcas(nombre, provincia) values("Seat", "Almeria");
insert into marcas(nombre, provincia) values("Renault", "Sevilla");
insert into marcas(nombre, provincia) values("Peugeot", "Granada");
insert into marcas(nombre, provincia) values("Toyota", "Jaen");
insert into marcas(nombre, provincia) values("Citroen", "Cordoba");
-- Creamos la base de datos
-- create database ejemplo2;
-- creamos un usuario
-- create user usuario1@'localhost' identified by "1234";
-- Le damos premisos en la base de datos
-- grant all on ejemplo2.* to usuario1@'localhost';

--  mysql -u usuario1 -p ejemplo2 
--  pegamos lo de arriba, en la terminal, el create table y los insert into