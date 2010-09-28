CREATE TABLE AccessType (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(30) NOT NULL,
    description VARCHAR(200) NOT NULL
);

INSERT INTO AccessType Values (1, 'SUCCESS', 'The user has successfully logged in');
INSERT INTO AccessType Values (2, 'LOG OUT', 'The user has successfully logged out');
INSERT INTO AccessType Values (3, 'FAILURE', 'The username and password does not match');
INSERT INTO AccessType Values (4, 'DO NOT EXIST', 'The username does not exist');

CREATE TABLE AccessLog (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(20) NOT NULL,
    ip VARCHAR(40) NOT NULL,
    timestamp TIMESTAMP NOT NULL,
    id_access_type INTEGER NOT NULL,
    CONSTRAINT accesstype_accesslog_fk FOREIGN KEY (id_access_type) REFERENCES AccessType (id)
);

CREATE TABLE ValidIp (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip VARCHAR(40) NOT NULL,
    ipv4 BOOLEAN NOT NULL
);

CREATE UNIQUE INDEX ip_idx ON ValidIp ( ip );

INSERT INTO ValidIp VALUES (1, '127.0.0.1', 1);
INSERT INTO ValidIp VALUES (2, '::1', 0);

CREATE TABLE Service (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(10) NOT NULL
);

CREATE TABLE Protocol (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(5) NOT NULL
);

CREATE TABLE Service_x_Protocol (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_service INTEGER NOT NULL,
    id_protocol INTEGER NOT NULL,
    CONSTRAINT service_service_x_protocol_fk FOREIGN KEY (id_service) REFERENCES Service (id),
    CONSTRAINT protocol_service_x_protocol_fk FOREIGN KEY (id_protocol) REFERENCES Protocol (id)
);

CREATE TABLE Port (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_service INTEGER NOT NULL,
    number SMALLINT(5) NOT NULL,
    CONSTRAINT service_port_fk FOREIGN KEY (id_service) REFERENCES Service (id)
);

CREATE TABLE Interface (
    id INTEGER NOT NULL,
    name VARCHAR(10) NOT NULL,
    lan BOOLEAN NOT NULL,
    description VARCHAR(200) NOT NULL,
    ip4 VARCHAR(15) NOT NULL,
    ip6 VARCHAR(40) NOT NULL,
    mac VARCHAR(17) NOT NULL,
    mask4 VARCHAR(15) NOT NULL,
    mask6 VARCHAR(40) NOT NULL,
    enable BOOLEAN NOT NULL
);

CREATE TABLE Subnet (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_interface INTEGER NOT NULL,
    name VARCHAR(30) NOT NULL,
    description VARCHAR(200) NOT NULL,
    ip4 VARCHAR(15) NOT NULL,
    ip6 VARCHAR(40) NOT NULL,
    mask4 VARCHAR(15) NOT NULL,
    mask6 VARCHAR(40) NOT NULL,
    CONSTRAINT interface_subnet_fk FOREIGN KEY (id_interface) REFERENCES Interface (id)
);

CREATE TABLE Node (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_subnet INTEGER NOT NULL,
    name VARCHAR(30) NOT NULL,
    ip VARCHAR(40) NOT NULL,
    mask VARCHAR(40) NOT NULL,
    CONSTRAINT subnet_node_fk FOREIGN KEY (id_subnet) REFERENCES Subnet (id)
);

CREATE TABLE Service_x_Node (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_service INTEGER NOT NULL,
    id_node INTEGER NOT NULL,
    CONSTRAINT service_service_x_node_fk FOREIGN KEY (id_service) REFERENCES Service (id),
    CONSTRAINT node_service_x_node_fk FOREIGN KEY (id_node) REFERENCES Node (id)
);

CREATE TABLE Privilege (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_piece INTEGER NOT NULL,
    name VARCHAR(30) NOT NULL,
    page VARCHAR(30) NOT NULL,
    event VARCHAR(10) NOT NULL,
    CONSTRAINT piece_piece_fk FOREIGN KEY (id_piece) REFERENCES Piece (id)
);

CREATE TABLE Role (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(30) NOT NULL,
    description VARCHAR(200) DEFAULT "" NOT NULL
);

INSERT INTO Role (id, name, description)
VALUES (1, 'Administrator', 'Default Role Administrator');

CREATE TABLE Role_x_Privilege (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_privilege INTEGER NOT NULL,
    id_role INTEGER NOT NULL,
    CONSTRAINT privilege_role_x_privilege_fk FOREIGN KEY (id_privilege) REFERENCES Task (id),
    CONSTRAINT role_role_x_privilege_fk FOREIGN KEY (id_role) REFERENCES Role (id)
);

CREATE TABLE Account (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_role INTEGER NOT NULL,
    username VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    token VARCHAR(210) NOT NULL,
    salt VARCHAR(20) NOT NULL,
    password CHAR(210) NOT NULL,
    changePassword BOOLEAN NOT NULL,
    enabled BOOLEAN NOT NULL,
    tokenDate TIMESTAMP NOT NULL,
    createdDate TIMESTAMP NOT NULL,
    modifiedDate TIMESTAMP NOT NULL,
    id_account_creator INTEGER NOT NULL,
    id_account_modifier INTEGER NOT NULL,
    CONSTRAINT account_modifier_account_fk FOREIGN KEY (id_account_modifier) REFERENCES Account (id),
    CONSTRAINT role_account_fk FOREIGN KEY (id_role) REFERENCES Role (id),
    CONSTRAINT account_creator_account_fk FOREIGN KEY (id_account_creator) REFERENCES Account (id)
);

CREATE UNIQUE INDEX username_idx ON Account ( username );

INSERT INTO Account (id,id_role,username,password,salt,email,token,enabled,createdDate,modifiedDate,tokenDate,id_account_creator,id_account_modifier,changePassword)
VALUES (1,1,'admin','','','','',1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1,1,1);

CREATE TABLE Piece (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(30) NOT NULL,
    enable BOOLEAN NOT NULL,
    description VARCHAR(200) NOT NULL,
    component BOOLEAN NOT NULL
);

