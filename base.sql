create database Tienda CHARACTER SET utf8;

create table Usuario(
usumai varchar(50) primary key,
usunom varchar(50) not null,
usuapp varchar(50) not null,
usuapm varchar(50) not null,
usupas varchar(255) not null,
usutip enum("admin","gestor","usuario") not null
)engine=InnoDB;


INSERT INTO usuario VALUES ('damian.huertag@gmail.com', 'Damián', 'Huerta', 'García', MD5('Damian001.'), 'admin');
