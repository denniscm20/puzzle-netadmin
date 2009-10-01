CREATE TABLE SquidAclType (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR(15) NOT NULL,
    description VARCHAR(200) NOT NULL
);


CREATE TABLE SquidAction (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    name VARCHAR(10) NOT NULL
);

CREATE TABLE SquidPredefinedRule (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    rule VARCHAR(100) NOT NULL,
    description VARCHAR(200) NOT NULL
);

CREATE TABLE SquidPredefinedRule_x_IptablesPredefinedRule (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    id_iptablesPredefinedRule INTEGER NOT NULL,
    id_squidPredefinedRule INTEGER NOT NULL,
    CONSTRAINT squidpredefinedrule_squidpredefinedrule_x_iptablespredefinedrule_fk FOREIGN KEY (id_squidPredefinedRule) REFERENCES SquidPredefinedRule (id),
    CONSTRAINT iptablespredefinedrule_squidpredefinedrule_x_iptablespredefinedrule_fk FOREIGN KEY (id_iptablesPredefinedRule) REFERENCES IptablesPredefinedRule (id)
);

CREATE TABLE Squid (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    icpPort SMALLINTEGER NOT NULL,
    cacheLog VARCHAR(100) NOT NULL,
    storeLog VARCHAR(100) NOT NULL,
    accessLog VARCHAR(100) NOT NULL,
    logFqdn BOOLEAN NOT NULL,
    description VARCHAR(100) NOT NULL,
    enable BOOLEAN NOT NULL,
    createdDate DATE NOT NULL,
    id_account_creator INTEGER NOT NULL,
    modifiedDate DATE NOT NULL,
    id_account_modifier INTEGER NOT NULL,
    lastApplyDate DATE NOT NULL,
    id_account_apply INTEGER NOT NULL,
    CONSTRAINT account_creator_squid_fk FOREIGN KEY (id_account_creator) REFERENCES Account (id),
    CONSTRAINT account_modifier_squid_fk FOREIGN KEY (id_account_modifier) REFERENCES Account (id),
    CONSTRAINT account_apply_squid_fk FOREIGN KEY (id_account_apply) REFERENCES Account (id)
);

CREATE TABLE SquidPort (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    id_squid INTEGER NOT NULL,
    port SMALLINTEGER NOT NULL,
    CONSTRAINT squid_squidport_fk FOREIGN KEY (id_squid) REFERENCES Squid (id)
);

CREATE TABLE Squid_x_PredefinedRule_x_Action (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    id_squidAction INTEGER NOT NULL,
    id_squidPredefinedRule INTEGER NOT NULL,
    id_squid INTEGER NOT NULL,
    CONSTRAINT squidaction_squidpredefinedrule_x_squid_x_action_fk FOREIGN KEY (id_squidAction) REFERENCES SquidAction (id),
    CONSTRAINT squidpredefinedrule_squidpredefinedrule_x_squid_x_action_fk FOREIGN KEY (id_squidPredefinedRule) REFERENCES SquidPredefinedRule (id),
    CONSTRAINT squid_squidpredefinedrule_x_squid_x_action_fk FOREIGN KEY (id_squid) REFERENCES Squid (id)
);

CREATE TABLE SquidCache (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    enable BOOLEAN NOT NULL,
    id_squid INTEGER NOT NULL,
    directory VARCHAR(100) NOT NULL,
    maxSize SMALLINTEGER NOT NULL,
    mainLevel SMALLINTEGER NOT NULL,
    subLevel SMALLINTEGER NOT NULL,
    CONSTRAINT squid_squidcache_fk FOREIGN KEY (id_squid) REFERENCES Squid (id)
);


CREATE TABLE SquidProxy (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    transparent BOOLEAN NOT NULL,
    enable BOOLEAN NOT NULL,
    id_squid INTEGER NOT NULL,
    CONSTRAINT squid_squidproxy_fk FOREIGN KEY (id_squid) REFERENCES Squid (id)
);

CREATE TABLE SquidAcl (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    id_squidCache INTEGER DEFAULT 0 NOT NULL,
    id_squidProxy INTEGER NOT NULL,
    id_squidAclType INTEGER NOT NULL,
    name VARCHAR(20) NOT NULL,
    filename VARCHAR(100) NOT NULL,
    CONSTRAINT squidacltype_squidacl_fk FOREIGN KEY (id_squidAclType) REFERENCES SquidAclType (id),
    CONSTRAINT squidcache_squidacl_fk FOREIGN KEY (id_squidCache) REFERENCES SquidCache (id),
    CONSTRAINT squidproxy_squidacl_fk FOREIGN KEY (id_squidProxy) REFERENCES SquidProxy (id)
);

CREATE TABLE SquidAclLine (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    id_squidAcl INTEGER NOT NULL,
    item VARCHAR(50) NOT NULL,
    CONSTRAINT squidacl_squidaclline_fk FOREIGN KEY (id_squidAcl) REFERENCES SquidAcl (id)
);

CREATE TABLE SquidRule (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    id_squidAction INTEGER NOT NULL,
    id_squidAcl INTEGER NOT NULL,
    CONSTRAINT squidaction_squidrule_fk FOREIGN KEY (id_squidAction) REFERENCES SquidAction (id),
    CONSTRAINT squidacl_squidrule_fk FOREIGN KEY (id_squidAcl) REFERENCES SquidAcl (id)
);

