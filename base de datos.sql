create database reproductor;
  
use reproductor;

create table interprete(
  id int primary key auto_increment,
  nombre varchar(100),
  imagen varchar(100)
);

create table genero(
  id int primary key auto_increment,
  nombre varchar(100),
  imagen varchar(100)
);

  create table canciones(
    id int primary key auto_increment,
    titulo varchar(100),
    archivo varchar(100),
    imagen varchar(100),
    idgenero int,
    idinterprete int,
    foreign key (idgenero) references genero(id),
    foreign key (idinterprete) references interprete(id)
  );