BEGIN TRANSACTION;

CREATE TABLE 'Table' (
  ID integer primary key,
  Nombre varchar(50)
, `Descripcion` varchar(255)
);

INSERT INTO "Table" VALUES(1,'Filter','Esta tabla contiene información sobre las reglas de filtrado que serán aplicadas al cortafuegos.');
INSERT INTO "Table" VALUES(2,'NAT','Esta tabla contiene información sobre las reglas que serán aplicadas al NAT.');

CREATE TABLE Politica (
  ID integer primary key,
  Nombre varchar(50), 
  Descripcion varchar(255)
);

INSERT INTO "Politica" VALUES(1,'ACCEPT','Aceptar los paquetes que no cumplan con las reglas definidas.');
INSERT INTO "Politica" VALUES(2,'DROP','Rechazar los paquetes que no cumplan con las reglas definidas');

CREATE TABLE 'Estado' (
  ID integer primary key,
  Nombre varchar(11),
  Descripcion varchar(100)
);

INSERT INTO "Estado" VALUES(1,'INVALID','El paquete no pudo ser identificado por algun error');
INSERT INTO "Estado" VALUES(2,'ESTABLISHED','Conexion en la que los paquetes provienen de ambas direcciones');
INSERT INTO "Estado" VALUES(3,'NEW','Conexion nueva o en la que los paquetes provienen de una direccion');
INSERT INTO "Estado" VALUES(4,'RELATED','Conexion nueva asociada a otra existente. Ej: FTP');

CREATE TABLE Protocolo (
  ID integer PRIMARY KEY,
  Nombre varchar(10),
  Descripcion varchar(100)
);

INSERT INTO "Protocolo" VALUES(1,'tcp','Protocolo TCP');
INSERT INTO "Protocolo" VALUES(2,'udp','Protocolo UDP');
INSERT INTO "Protocolo" VALUES(3,'icmp','Protocolo ICMP');

CREATE TABLE `ReglaIptables` (
  `ID` integer PRIMARY KEY ,
  `IptablesID` integer,
  `CadenaID` integer,
  `AccionID` integer,
  `PuertoOrigenInicial` integer,
  `PuertoOrigenFinal` integer,
  `PuertoDestinoInicial` integer,
  `PuertoDestinoFinal` integer,
  `IPOrigen` varchar(15),
  `MascaraOrigen` integer,
  `ProtocoloID` integer,
  `InterfazDestinoID` integer,
  `IPDestino` varchar(15),
  `MascaraDestino` integer,
  `InterfazOrigenID` integer,
  `EstadoID` integer,
  `MAC` varchar(17)
);

CREATE TABLE Categoria (
  ID integer primary key,
  Nombre varchar(30)
);

INSERT INTO "Categoria" VALUES(1,'Chat');
INSERT INTO "Categoria" VALUES(2,'Base de Datos');
INSERT INTO "Categoria" VALUES(3,'Transferencia de Archivos');
INSERT INTO "Categoria" VALUES(4,'Inicio de Sesión Remoto');
INSERT INTO "Categoria" VALUES(5,'Correo');
INSERT INTO "Categoria" VALUES(6,'Redes');

CREATE TABLE ReglaPredefinida (
  ID integer primary key,
  CategoriaID integer,
  Nombre varchar(20)
);

INSERT INTO "ReglaPredefinida" VALUES(1,1,'AOL');
INSERT INTO "ReglaPredefinida" VALUES(2,1,'IRC');
INSERT INTO "ReglaPredefinida" VALUES(3,1,'Jabber');
INSERT INTO "ReglaPredefinida" VALUES(4,1,'MSN');
INSERT INTO "ReglaPredefinida" VALUES(5,1,'Yahoo');
INSERT INTO "ReglaPredefinida" VALUES(6,2,'MySQL');
INSERT INTO "ReglaPredefinida" VALUES(7,2,'Postgresql');
INSERT INTO "ReglaPredefinida" VALUES(8,2,'MSSQL');
INSERT INTO "ReglaPredefinida" VALUES(9,3,'HTTP');
INSERT INTO "ReglaPredefinida" VALUES(10,3,'HTTPS');
INSERT INTO "ReglaPredefinida" VALUES(11,3,'FTP');
INSERT INTO "ReglaPredefinida" VALUES(12,4,'SSH');
INSERT INTO "ReglaPredefinida" VALUES(13,4,'VNC');
INSERT INTO "ReglaPredefinida" VALUES(14,4,'Telnet');
INSERT INTO "ReglaPredefinida" VALUES(15,5,'IMAP');
INSERT INTO "ReglaPredefinida" VALUES(16,5,'POP3');
INSERT INTO "ReglaPredefinida" VALUES(17,5,'SMTP');
INSERT INTO "ReglaPredefinida" VALUES(18,6,'Ping');
INSERT INTO "ReglaPredefinida" VALUES(19,6,'Squid');
INSERT INTO "ReglaPredefinida" VALUES(20,6,'DNS');
INSERT INTO "ReglaPredefinida" VALUES(21,6,'DHCP');

CREATE TABLE ReglaPredefinidaIptablesXReglaPredefinidaSquid ( 
  ID integer PRIMARY KEY,
  ReglaPredefinidaIptablesID integer,
  ReglaPredefinidaSquidID integer
);

INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (1,4,1);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (2,4,2);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (3,5,3);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (4,5,4);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (5,5,5);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (6,5,6);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (7,5,7);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (8,5,8);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (9,5,9);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (10,5,10);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (11,5,11);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (12,5,12);
INSERT INTO ReglaPredefinidaIptablesXReglaPredefinidaSquid VALUES (13,1,13);

CREATE TABLE `Iptables` (
  `ID` integer PRIMARY KEY , 
  `Descripcion` varchar(100),
  `Activo` boolean
);

CREATE TABLE Cadena (
  ID integer primary key,
  TableID integer,
  Nombre varchar(50),
  Descripcion varchar(255)
);

INSERT INTO "Cadena" VALUES(1,1,'INPUT','Esta cadena contiene la lista de políticas a aplicar sobre los paquetes que tengan como destino este servidor.');
INSERT INTO "Cadena" VALUES(2,1,'OUTPUT','Esta cadena contiene la lista de políticas a aplicar sobre los paquetes que tengan como origen este servidor.');
INSERT INTO "Cadena" VALUES(3,1,'FORWARD','Esta cadena contiene la lista de políticas a aplicar sobre los paquetes que tengan un origen y destino distintos a este servidor.');
INSERT INTO "Cadena" VALUES(4,2,'PREROUTING','Las políticas de NAT se aplicarán al llegar el paquete al servidor.');
INSERT INTO "Cadena" VALUES(5,2,'POSTROUTING','Las políticas de NAT se aplicarán previamente a que el paquete sea enviado por la red.');

CREATE TABLE Accion (
  ID integer primary key,
  Nombre varchar(8),
  Descripcion varchar(100),
  TableID integer
);

INSERT INTO "Accion" VALUES(1,'ACCEPT','Aceptar paquetes entrantes',1);
INSERT INTO "Accion" VALUES(2,'DROP','Denegar paquetes entrantes',1);
INSERT INTO "Accion" VALUES(3,'LOG','Registrar paquetes',1);
INSERT INTO "Accion" VALUES(4,'REDIRECT','Redirecciona los paquetes recibidos por un puerto local a otro puerto local.',2);
INSERT INTO "Accion" VALUES(5,'MASQUERADE','Equipo(s) con IP privada necesita(n) acceder a Internet con una IP pública dinámica.',2);
INSERT INTO "Accion" VALUES(6,'DNAT','Equipo de Internet necesita contactar un servidor de la red local con IP estática privada.',2);
INSERT INTO "Accion" VALUES(7,'SNAT','Equipo(s) con IP privada necesita(n) acceder a Internet con IP pública estática.',2);

CREATE TABLE 'IptablesXReglaPredefinidaXAccion' (
  ID integer primary key,
  IptablesID integer,
  ReglaPredefinidaID  integer, 
  `AccionID` integer
);

CREATE TABLE `DetalleReglaPredefinida` (
  `ID` integer PRIMARY KEY ,
  `ReglaPredefinidaID` integer,
  `Regla` varchar(150)
);

INSERT INTO `DetalleReglaPredefinida` VALUES(1,1,'-A FORWARD -p tcp --dport 5190');
INSERT INTO `DetalleReglaPredefinida` VALUES(2,1,'-A OUTPUT -p tcp --dport 5190');
INSERT INTO `DetalleReglaPredefinida` VALUES(3,2,'-A OUTPUT -p tcp --dport 6667');
INSERT INTO `DetalleReglaPredefinida` VALUES(4,2,'-A FORWARD -p tcp --dport 6667');
INSERT INTO `DetalleReglaPredefinida` VALUES(5,3,'-A OUTPUT -p tcp --dport 5222');
INSERT INTO `DetalleReglaPredefinida` VALUES(6,3,'-A OUTPUT -p tcp --dport 5223');
INSERT INTO `DetalleReglaPredefinida` VALUES(7,3,'-A FORWARD -p tcp --dport 5222');
INSERT INTO `DetalleReglaPredefinida` VALUES(8,3,'-A FORWARD -p tcp --dport 5223');
INSERT INTO `DetalleReglaPredefinida` VALUES(9,4,'-A FORWARD -p tcp --dport 1863');
INSERT INTO `DetalleReglaPredefinida` VALUES(10,4,'-A OUTPUT -p tcp --dport 1863');
INSERT INTO `DetalleReglaPredefinida` VALUES(11,5,'-A FORWARD -p tcp --dport 5050');
INSERT INTO `DetalleReglaPredefinida` VALUES(12,5,'-A OUTPUT -p tcp --dport 5050');
INSERT INTO `DetalleReglaPredefinida` VALUES(13,6,'-A INPUT -p tcp --dport 3306');
INSERT INTO `DetalleReglaPredefinida` VALUES(14,6,'-A FORWARD -p tcp --dport 3306');
INSERT INTO `DetalleReglaPredefinida` VALUES(15,6,'-A OUTPUT -p tcp --sport 3306');
INSERT INTO `DetalleReglaPredefinida` VALUES(16,7,'-A INPUT -p tcp --dport 5432');
INSERT INTO `DetalleReglaPredefinida` VALUES(17,7,'-A FORWARD -p tcp --dport 5432');
INSERT INTO `DetalleReglaPredefinida` VALUES(18,7,'-A OUTPUT -p tcp --sport 5432');
INSERT INTO `DetalleReglaPredefinida` VALUES(19,8,'-A FORWARD -p tcp --sport 1433');
INSERT INTO `DetalleReglaPredefinida` VALUES(20,9,'-A INPUT -p tcp --dport 80');
INSERT INTO `DetalleReglaPredefinida` VALUES(21,9,'-A FORWARD -p tcp --dport 80');
INSERT INTO `DetalleReglaPredefinida` VALUES(22,10,'-A INPUT -p tcp --dport 443');
INSERT INTO `DetalleReglaPredefinida` VALUES(23,10,'-A FORWARD -p tcp --dport 443');
INSERT INTO `DetalleReglaPredefinida` VALUES(24,11,'-A INPUT -p tcp --dport 20:21');
INSERT INTO `DetalleReglaPredefinida` VALUES(25,11,'-A FORWARD -p tcp --dport 20:21');
INSERT INTO `DetalleReglaPredefinida` VALUES(26,12,'-A INPUT -p tcp --dport 22');
INSERT INTO `DetalleReglaPredefinida` VALUES(27,12,'-A FORWARD -p tcp --dport 22');
INSERT INTO `DetalleReglaPredefinida` VALUES(28,13,'-A INPUT -p tcp --dport 5901');
INSERT INTO `DetalleReglaPredefinida` VALUES(29,13,'-A INPUT -p tcp --dport 5801');
INSERT INTO `DetalleReglaPredefinida` VALUES(30,13,'-A FORWARD -p tcp --dport 5901');
INSERT INTO `DetalleReglaPredefinida` VALUES(31,13,'-A FORWARD -p tcp --dport 5801');
INSERT INTO `DetalleReglaPredefinida` VALUES(32,13,'-A FORWARD -p tcp --dport 5900');
INSERT INTO `DetalleReglaPredefinida` VALUES(33,13,'-A FORWARD -p tcp --dport 5800');
INSERT INTO `DetalleReglaPredefinida` VALUES(34,14,'-A INPUT -p tcp --dport telnet');
INSERT INTO `DetalleReglaPredefinida` VALUES(35,14,'-A FORWARD -p tcp --dport telnet');
INSERT INTO `DetalleReglaPredefinida` VALUES(36,15,'-A INPUT -p tcp --dport 143');
INSERT INTO `DetalleReglaPredefinida` VALUES(37,15,'-A FORWARD -p tcp --dport 143');
INSERT INTO `DetalleReglaPredefinida` VALUES(38,16,'-A INPUT -p tcp --dport 110');
INSERT INTO `DetalleReglaPredefinida` VALUES(39,16,'-A FORWARD -p tcp --dport 110');
INSERT INTO `DetalleReglaPredefinida` VALUES(40,17,'-A INPUT -p tcp --dport 25');
INSERT INTO `DetalleReglaPredefinida` VALUES(41,17,'-A FORWARD -p tcp --dport 25');
INSERT INTO `DetalleReglaPredefinida` VALUES(42,18,'-A INPUT -p icmp');
INSERT INTO `DetalleReglaPredefinida` VALUES(43,18,'-A FORWARD -p icmp');
INSERT INTO `DetalleReglaPredefinida` VALUES(44,19,'-A INPUT -p tcp --dport 3128');
INSERT INTO `DetalleReglaPredefinida` VALUES(45,19,'-A FORWARD -p tcp --dport 3128');
INSERT INTO `DetalleReglaPredefinida` VALUES(46,20,'-A INPUT -p udp --dport 53');
INSERT INTO `DetalleReglaPredefinida` VALUES(47,20,'-A INPUT -p tcp --dport 53');
INSERT INTO `DetalleReglaPredefinida` VALUES(48,20,'-A FORWARD -p udp --dport 53');
INSERT INTO `DetalleReglaPredefinida` VALUES(49,20,'-A FORWARD -p tcp --dport 53');
INSERT INTO `DetalleReglaPredefinida` VALUES(50,21,'-A INPUT -p udp --dport 67:68 --sport 67:68');
INSERT INTO `DetalleReglaPredefinida` VALUES(51,21,'-A INPUT -p udp --dport 67:68 --sport 67:68');

CREATE TABLE `HistoricoIptables` (
  `ID` integer PRIMARY KEY ,
  `IptablesID` integer,
  `FechaCreacion` varchar(8),
  `Descripcion` varchar(100), 
  `HoraCreacion` varchar(5)
);

CREATE TABLE FechaActivacionIptables (
  `ID` integer PRIMARY KEY ,
  `HistoricoIptablesID` integer,
  `FechaActivacion` varchar(8),
  `HoraActivacion` varchar(5)
);

CREATE TABLE IptablesXCadenaXPolitica (
  ID integer primary key,
  IptablesID integer,
  CadenaID  integer,
  PoliticaID integer
);

COMMIT;