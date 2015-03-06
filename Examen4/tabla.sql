create table mispruebas.login (usuario VARCHAR(20) NOT NULL,
clave VARCHAR(20) NOT NULL,
nombre VARCHAR(20) NOT NULL,
apellidos VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
PRIMARY KEY (usuario)) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

create table mispruebas.visitas (visitas int(6)) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
insert into mispruebas.visitas values(0);
