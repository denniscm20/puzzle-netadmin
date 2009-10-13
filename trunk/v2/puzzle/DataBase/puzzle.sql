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
    date DATE NOT NULL,
    time TIME NOT NULL,
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
    id INTEGER NOT NULL,
    id_service INTEGER NOT NULL,
    name VARCHAR(5) NOT NULL,
    CONSTRAINT service_protocol_fk FOREIGN KEY (id_service) REFERENCES Service (id)
);

CREATE TABLE Port (
    id INTEGER NOT NULL,
    id_service INTEGER NOT NULL,
    number SMALLINT(5) NOT NULL,
    CONSTRAINT service_port_fk FOREIGN KEY (id_service) REFERENCES Service (id)
);

CREATE TABLE Interface (
    id INTEGER NOT NULL,
    name VARCHAR(10) NOT NULL,
    lan BOOLEAN NOT NULL,
    description VARCHAR(200) NOT NULL,
    ip VARCHAR(40) NOT NULL,
    mac VARCHAR(17) NOT NULL,
    mask VARCHAR(40) NOT NULL,
    enable BOOLEAN NOT NULL
);

CREATE TABLE Subnet (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_interface INTEGER NOT NULL,
    name VARCHAR(30) NOT NULL,
    description VARCHAR(200) NOT NULL,
    ip VARCHAR(40) NOT NULL,
    mask VARCHAR(40) NOT NULL,
    shortmask SMALLINTEGER NOT NULL,
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

CREATE TABLE Task (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(30) NOT NULL
);

CREATE TABLE Role (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(30) NOT NULL,
    description VARCHAR(200) DEFAULT "" NOT NULL
);

INSERT INTO Role (id, name, description)
VALUES (1, 'Administrator', 'Default Role Administrator');

CREATE TABLE Role_x_Task (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_task INTEGER NOT NULL,
    id_role INTEGER NOT NULL,
    CONSTRAINT task_role_x_task_fk FOREIGN KEY (id_task) REFERENCES Task (id),
    CONSTRAINT role_role_x_task_fk FOREIGN KEY (id_role) REFERENCES Role (id)
);

CREATE TABLE Account (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_role INTEGER NOT NULL,
    username VARCHAR(20) NOT NULL,
    salt VARCHAR(20) NOT NULL,
    password VARCHAR(210) NOT NULL,
    changePassword BOOLEAN NOT NULL,
    enabled BOOLEAN NOT NULL,
    createdDate DATETIME NOT NULL,
    modifiedDate DATETIME NOT NULL,
    id_account_creator INTEGER NOT NULL,
    id_account_modifier INTEGER NOT NULL,
    CONSTRAINT account_modifier_account_fk FOREIGN KEY (id_account_modifier) REFERENCES Account (id),
    CONSTRAINT role_account_fk FOREIGN KEY (id_role) REFERENCES Role (id),
    CONSTRAINT account_creator_account_fk FOREIGN KEY (id_account_creator) REFERENCES Account (id)
);

CREATE UNIQUE INDEX username_idx ON Account ( username );

INSERT INTO Account (id,id_role,username,password,enabled,createdDate,modifiedDate,id_account_creator,id_account_modifier,changePassword)
VALUES (1,1,'admin','',1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1,1,1)

CREATE TABLE Puzzle (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    hostname VARCHAR(50) NOT NULL,
    dns1 VARCHAR(40) NOT NULL,
    dns2 VARCHAR(40) NOT NULL,
    forward BOOLEAN NOT NULL
);

CREATE TABLE Piece (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(30) NOT NULL,
    enable BOOLEAN NOT NULL,
    description VARCHAR(200) NOT NULL,
    component BOOLEAN NOT NULL
);

