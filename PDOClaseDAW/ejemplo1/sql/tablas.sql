create table autores(
    id_autor int auto_increment primary key,
    apellidos varchar(60) not null,
    nombre varchar(40) not null
);
create table libros(
    id_libro int auto_increment primary key,
    titulo varchar(80) not null,
    isbn varchar(13),
    autor int,
    portada varchar(80) default "./img/default.jpg",
    constraint lib_autor foreign key(autor) references autores(id_autor) on update cascade on delete set null
);
-- mysql -u root
-- create datebase base1;
-- create user usuario@'localhost' identified by "secreto";
-- grant all on base1.* to usuario@'localhost';
-- exit
-- mysql -u usuario -p base1
-- pide contraseña: secreto
-- exit

--En la ruta de la tabla
-- C:\xampp\htdocs\profe\pdo\ejemplo1\sql>mysql -u usuario -p base1 < tablas.sql
-- nos pide contraseña seguimos

-- mysql -u usuario -p          Entrar a mysql con el usuario->usuario
-- show databases;              mostrar las base de datos
-- use nombrededatabase;        Entrar en la base de datos
-- show tables;                 Mostrar tablas de la base de datos