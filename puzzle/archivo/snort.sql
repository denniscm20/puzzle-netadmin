BEGIN TRANSACTION;

CREATE TABLE TipoValor ( 
  ID integer PRIMARY KEY,
  Nombre varchar(20),
  Descripcion varchar(255)
);

INSERT INTO "TipoValor" VALUES(1,'Directorio','directory');
INSERT INTO "TipoValor" VALUES(2,'Archivo','file');
INSERT INTO "TipoValor" VALUES(3,'Ninguno','');

CREATE TABLE TipoPreprocesador ( 
  ID integer PRIMARY KEY,
  Nombre varchar(20),
  Descripcion varchar(255)
);

INSERT INTO "TipoPreprocesador" VALUES(1,'flow','Unifica los diversos mecanismos de seguridad de Snort');
INSERT INTO "TipoPreprocesador" VALUES(2,'frag2','Soporte para defagmentación IP');
INSERT INTO "TipoPreprocesador" VALUES(3,'frag3_global','Objetivo basado en defragmentación IP (parte 1)');
INSERT INTO "TipoPreprocesador" VALUES(4,'frag3_engine','Objetivo basado en defragmentación IP (parte 2)');
INSERT INTO "TipoPreprocesador" VALUES(5,'stream4','Stateful inspection/stream reassembly (parte 1)');
INSERT INTO "TipoPreprocesador" VALUES(6,'stream4_reassemble','Stateful inspection/stream reassembly (parte 2)');
INSERT INTO "TipoPreprocesador" VALUES(7,'http_inspect','Detecta anomalías en el tráfico http. (parte 1)');
INSERT INTO "TipoPreprocesador" VALUES(8,'http_inspect_server','Detecta anomalías en el tráfico http. (parte 2)');
INSERT INTO "TipoPreprocesador" VALUES(9,'bo','Detector de Back Orifice');
INSERT INTO "TipoPreprocesador" VALUES(10,'sfportscan','Detecta escaneos y barridos de puerto');
INSERT INTO "TipoPreprocesador" VALUES(11,'arpspoof','Detección de ataques ARP');


CREATE TABLE TipoLibreria ( 
  ID integer PRIMARY KEY,
  Nombre varchar(20),
  Descripcion varchar(255)
);

INSERT INTO "TipoLibreria" VALUES(1,'Motor Dinámico','dynamicengine');
INSERT INTO "TipoLibreria" VALUES(2,'Preprocesador Dinámico','dynamicpreprocessor');
INSERT INTO "TipoLibreria" VALUES(3,'Regla Dinámica','dynamicdetection');

CREATE TABLE TipoServicio ( 
  ID integer PRIMARY KEY,
  Nombre varchar(20),
  Descripcion varchar(255)
);

INSERT INTO "TipoServicio" VALUES(1,'DNS','');
INSERT INTO "TipoServicio" VALUES(2,'SMTP','');
INSERT INTO "TipoServicio" VALUES(3,'HTTP','');
INSERT INTO "TipoServicio" VALUES(4,'SQL','');
INSERT INTO "TipoServicio" VALUES(5,'Telnet','');
INSERT INTO "TipoServicio" VALUES(6,'SNMP','');

CREATE TABLE Parametro ( 
  ID integer PRIMARY KEY,
  TipoPreprocesadorID integer,
  Nombre varchar(20),
  Descripcion varchar(255)
);

INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(1,1,'stats_interval','Envía estadísticas a la salida estándar cad cierto intervalo de tiempo (segundos); setear en cero(0) para desactivar');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(2,1,'hash','Método hash (1: byte; 2: enteros); protección contr ataques algorítmicos');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(3,3,'max_frags','Número máximo activo de rastreadores de fragmentos');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(4,3,'memcap','Número máximo de memoria que podrá utilizar');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(5,3,'prealloc_frags','Número máximo de fragmentos a procesar en simultáneo');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(6,4,'timeout','Tiempo que el fragmento estará activo antes de expirar');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(7,4,'detect_anomalies','Detectar anomalías.');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(8,5,'disable_evasion_alerts','Tiempo que el fragmento estará activo antes de expirar');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(9,5,'timeout','Tiempo que estará activa la sesión.');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(10,5,'memcap','Limite de la memoria a utilizar.');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(11,7,'global','No tiene un valor definido');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(12,7,'iis_unicode_map unicode.map 1252','Valor: unicode.map 1252');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(13,8,'default profile all','Valores: all, iis, apache');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(14,8,'ports','Valores entre llaves({}), separados por espacios');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(15,8,'oversize_dir_length','Longitud máxima para el nombre de un directorio URL');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(16,10,'proto','Valores entre llaves ({}) y separados por espacios: tcp udp icmp ip all');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(17,10,'scan_type','Valores entre llaves ({}) y separados por espacios: portscan portsweep decoy_portscan distributed_portscan all');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(18,10,'sense_level','Valor entre llaves ({}): low|medium|high');
INSERT INTO "Parametro" (ID, TipoPreprocesadorID, Nombre, Descripcion) VALUES(19,10,'memcap','Valor entre llaves ({})');

CREATE TABLE ReglaPredefinida ( 
  ID integer PRIMARY KEY,
  Nombre varchar(20),
  Descripcion varchar(255),
  Regla varchar(50)
);

INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Local','Reglas de acceso local','local.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Mal Tráfico','','bad-traffic.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Exploit','','exploit.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Scan','','scan.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Finger','','finger.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('FTP','','ftp.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Telnet','','telnet.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Rpc','','rpc.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('RServices','','rservices.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('DOS','','dos.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('DDOS','','ddos.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('DNS','','dns.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('TFTP','','tftp.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('cgi','','web-cgi.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('coldfusion','','web-coldfusion.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('iis','','web-iis.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('frontpage','','web-frontpage.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('misc','','web-misc.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('clientes','','web-client.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('php','','web-php.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('sql','','sql.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('x11','','x11.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('icmp','','icmp.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('netbios','','netbios.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('misc','','misc.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Respuesta a Ataques','','attack-responses.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Oracle','','oracle.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Mysql','','mysql.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('SNMP','','snmp.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('SMTP','','smtp.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('IMAP','','imap.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('POP2','','pop2.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('POP3','','pop3.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('NNTP','','nntp.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('IDS','','other-ids.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('ataques web','','web-attacks.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('backdoor','','backdoor.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Shellcode','','shellcode.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Policy','','policy.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Porno','','porn.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Info','','info.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('ICMP','','icmp-info.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Virus','','virus.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Chat','','chat.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Multimedia','','multimedia.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('P2p','','p2p.rules');
INSERT INTO ReglaPredefinida (Nombre, Descripcion, Regla) VALUES ('Experimental','','experimental.rules');

CREATE TABLE SnortXReglaPredefinida ( 
  ID integer PRIMARY KEY,
  SnortID integer,
  ReglaPredefinidaID integer
);

CREATE TABLE InterfazInternaxSnort ( 
  ID integer PRIMARY KEY,
  SnortID integer,
  InterfazID integer
);

CREATE TABLE InterfazExternaxSnort ( 
  ID integer PRIMARY KEY,
  SnortID integer,
  InterfazID integer
);

CREATE TABLE Snort ( 
  ID integer PRIMARY KEY,
  RutaReglas varchar(100),
  RecursosLimitados boolean,
  `Activo` boolean
);

CREATE TABLE Preprocesador ( 
  ID integer PRIMARY KEY,
  SnortID integer,
  TipoPreprocesadorID integer
);

CREATE TABLE Libreria ( 
  ID integer PRIMARY KEY,
  TipoLibreriaID integer,
  TipoValorID integer,
  SnortID integer,
  Valor varchar(100)
);

CREATE TABLE Servicio ( 
  ID integer PRIMARY KEY,
  TipoServicioID integer,
  SnortID integer,
  Puertos varchar(100)
);

CREATE TABLE ParametroxPreprocesador ( 
  ID integer PRIMARY KEY,
  PreprocesadorID integer,
  ParametroID integer,
  Valor varchar(20)
);

CREATE TABLE NodoxServicio ( 
  ID integer PRIMARY KEY,
  NodoID integer,
  ServicioID integer
);

CREATE TABLE HistoricoSnort ( 
  ID integer PRIMARY KEY,
  SnortID integer,
  FechaCreacion varchar(8) ,
  HoraCreacion varchar(5) ,
  Descripcion varchar(100)
);

CREATE TABLE FechaActivacionSnort ( 
  ID integer PRIMARY KEY,
  HistoricoSnortID integer,
  FechaActivacion varchar(8),
  HoraActivacion varchar(5)
);

COMMIT;