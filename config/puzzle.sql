BEGIN TRANSACTION;
CREATE TABLE Usuario (
  ID integer primary key,
  Nombre varchar(20),
  Password varchar(255),
  Administrador boolean
);
INSERT INTO "Usuario" VALUES(1,'admin','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec',1);
CREATE TABLE Servidor (
  ID integer primary key,
  DNS1 varchar(15),
  DNS2 varchar(15),
  Gateway varchar(15),
  Reenvio boolean,
  Hostname varchar(50)
);
INSERT INTO "Servidor" (ID, DNS1, DNS2, Gateway, Hostname) VALUES(1, "", "", "", "");
CREATE TABLE IPv4Valida (
  ID integer primary key,
  ServidorID integer,
  IP varchar(15)
);
INSERT INTO "IPv4Valida" VALUES(1,1,'127.0.0.1');
CREATE TABLE Interfaz (
  ID integer primary key,
  ServidorID integer,
  IP varchar(15),
  MAC varchar(17),
  Nombre varchar(10),
  Descripcion varchar(20),
  Internet boolean,
  Mascara varchar(15)
);
CREATE TABLE Subred (
  ID integer primary key,
  InterfazID integer,
  Nombre varchar(50),
  IP varchar(15),
  Mascara varchar(15),
  MascaraCorta integer
);
CREATE TABLE Nodo (
  ID integer PRIMARY KEY ,
  SubredID integer,
  Hostname varchar(50),
  IP varchar(15)
);
CREATE TABLE RegistroHistorico (
  ID integer PRIMARY KEY,
  Fecha varchar(8),
  Hora varchar(5),
  IP varchar(15),
  Browser varchar(100),
  Usuario varchar(20),
  Mensaje varchar(255)
);
COMMIT;