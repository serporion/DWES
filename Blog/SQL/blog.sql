-- Active: 1731922560437@@127.0.0.1@3306@blog
CREATE DATABASE IF NOT EXISTS blog;
SET NAMES utf8mb4;
USE blog;


DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS usuarios( 
id              int(255) auto_increment not null,
nombre		varchar(100) not null,
apellidos	varchar(100) not null,
email		varchar(255) not null,
password	varchar(255) not null,
fecha               date not null,
rol               int(1) not null,
CONSTRAINT pk_usuarios PRIMARY KEY(id),
UNIQUE KEY correo_UNIQUE(email)
)ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


DROP TABLE IF EXISTS categorias;
CREATE TABLE IF NOT EXISTS categorias( 
id              int auto_increment not null,
nombre		varchar(100),
CONSTRAINT pk_categorias PRIMARY KEY(id),
UNIQUE KEY nombre_UNIQUE(nombre)
)ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


DROP TABLE IF EXISTS entradas;
CREATE TABLE IF NOT EXISTS entradas(
    id          int(255) auto_increment not null,
    usuario_id	int(255),
    categoria_id	int(255),
    titulo 		varchar(64) not null,
    descripcion	mediumtext,
    fecha		date default null,
    CONSTRAINT pk_entradas PRIMARY KEY(id),
    CONSTRAINT fk_id_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id),
    CONSTRAINT fk_id_categorias FOREIGN KEY(categoria_id) REFERENCES categorias(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
