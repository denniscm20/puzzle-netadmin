BEGIN TRANSACTION;

CREATE TABLE Accion ( 
  ID integer PRIMARY KEY,
  Nombre varchar(10),
  Descripcion varchar(100)
);
INSERT INTO "Accion" VALUES(1,'allow','Permitir');
INSERT INTO "Accion" VALUES(2,'deny','Denegar');

CREATE TABLE TipoACL ( 
  ID integer PRIMARY KEY,
  Nombre varchar(10),
  Descripcion varchar(100)
);
INSERT INTO "TipoACL" VALUES(1,'src','Acceder a Internet desde el siguiente IP local.');
INSERT INTO "TipoACL" VALUES(2,'dst','Acceder desde Internet al siguiente IP local.');
INSERT INTO "TipoACL" VALUES(3,'srcdomain','Acceder a Internet desde el siguiente dominio local.');
INSERT INTO "TipoACL" VALUES(4,'dstdomain','Acceder desde Internet  al siguiente dominio de la red.');
INSERT INTO "TipoACL" VALUES(5,'url_regex','URLs que contengan la siguiente palabra.');
INSERT INTO "TipoACL" VALUES(6,'url_regex','Archivos que contengan la siguiente extensión.');

CREATE TABLE TipoAcceso ( 
  ID integer PRIMARY KEY,
  Nombre varchar(10),
  Descripcion varchar(100)
);

INSERT INTO "TipoAcceso" VALUES(1,'http_access','Acceso a sitios HTTP.');
INSERT INTO "TipoAcceso" VALUES(2,'no_cache','Información a no almacenar en la caché.');

CREATE TABLE ListaControlAcceso ( 
  ID integer PRIMARY KEY,
  ReglaSquidID integer,
  TipoACLID integer,
  Nombre varchar(20)
);

CREATE TABLE Valor ( 
  ID integer PRIMARY KEY,
  ListaControlAccesoID integer,
  Nombre varchar(50)
);

CREATE TABLE ReglaPredefinida ( 
  ID integer PRIMARY KEY,
  Nombre varchar(20),
  Descripcion varchar(100),
  Regla varchar(255)
);

INSERT INTO ReglaPredefinida VALUES (1,'MSN','Bloquear el MSN cuando éste haga uso del puerto 80','acl ReglaPredefinida req_mime_type ^application/x-msn-messenger');
INSERT INTO ReglaPredefinida VALUES (2,'MSN','Bloquear el gateway del MSN cuando éste haga uso del puerto 80','acl ReglaPredefinida url_regex -i gateway.dll');
INSERT INTO ReglaPredefinida VALUES (4,'Yahoo','Bloquear el Yahoo','acl ReglaPredefinida dstdomain pager.yahoo.com');
INSERT INTO ReglaPredefinida VALUES (5,'Yahoo','Bloquear el Yahoo','acl ReglaPredefinida dstdomain shttp.msg.yahoo.com');
INSERT INTO ReglaPredefinida VALUES (6,'Yahoo','Bloquear el Yahoo','acl ReglaPredefinida dstdomain update.messenger.yahoo.com');
INSERT INTO ReglaPredefinida VALUES (7,'Yahoo','Bloquear el Yahoo','acl ReglaPredefinida dstdomain update.pager.yahoo.com');
INSERT INTO ReglaPredefinida VALUES (8,'Yahoo','Bloquear el Yahoo','acl ReglaPredefinida req_mime_type ^application/x-msn-messenger');
INSERT INTO ReglaPredefinida VALUES (9,'Yahoo','Bloquear el Yahoo','acl ReglaPredefinida req_mime_type ^application/x-msn-messenger');
INSERT INTO ReglaPredefinida VALUES (10,'Yahoo','Bloquear el Yahoo','acl ReglaPredefinida req_mime_type ^application/x-msn-messenger');
INSERT INTO ReglaPredefinida VALUES (11,'Yahoo','Bloquear el Yahoo','acl ReglaPredefinida req_mime_type ^application/x-msn-messenger');
INSERT INTO ReglaPredefinida VALUES (12,'Yahoo','Bloquear el Yahoo','acl ReglaPredefinida req_mime_type ^application/x-msn-messenger');
INSERT INTO ReglaPredefinida VALUES (13,'AOL','Bloquear el AOL','acl ReglaPredefinida dstdomain login.oscar.aol.com');

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

CREATE TABLE Squid ( 
  ID integer PRIMARY KEY,
  IcpPort integer,
  VisibleHostname varchar(100),
  CacheDir varchar(100),
  CacheMaxSize integer,
  DirNumber1 integer,
  DirNumber2 integer,
  CacheLog varchar(100),
  StoreLog varchar(100),
  AccessLog varchar(100),
  LogFqdn boolean,
  DnsNameservers varchar(100),
  Transparent boolean,
  Activo boolean
);

CREATE TABLE SquidxReglaPredefinida ( 
  ID integer PRIMARY KEY,
  SquidID integer,
  ReglaPredefinidaID integer
);

CREATE TABLE PuertoSquid ( 
  ID integer PRIMARY KEY,
  InterfazID integer,
  SquidID integer,
  Puerto integer,
  Descripcion varchar(100)
);

CREATE TABLE ReglaSquid ( 
  ID integer PRIMARY KEY,
  SquidID integer,
  AccionID integer,
  TipoAccesoID integer
);

CREATE TABLE HistoricoSquid ( 
  ID integer PRIMARY KEY,
  SquidID integer,
  FechaCreacion varchar(8) ,
  HoraCreacion varchar(5) ,
  Descripcion varchar(100)
);

CREATE TABLE FechaActivacionSquid ( 
  ID integer PRIMARY KEY,
  HistoricoSquidID integer,
  FechaActivacion varchar(8),
  HoraActivacion varchar(5)
);

COMMIT;