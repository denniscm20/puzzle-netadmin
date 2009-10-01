CREATE TABLE SnortOption (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(15) NOT NULL,
    description VARCHAR(200) NOT NULL,
    datatype VARCHAR(15) NOT NULL,
    syntax VARCHAR(10) NOT NULL
);

CREATE TABLE SnortDirection (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(20) NOT NULL,
    symbol CHAR(2) NOT NULL
);

CREATE TABLE SnortAction (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(10) NOT NULL,
    description VARCHAR(100) NOT NULL
);

CREATE TABLE SnortPredefinedRule (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(10) NOT NULL,
    rule VARCHAR(20) NOT NULL
);

CREATE TABLE SnortPreprocessor (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(20) NOT NULL,
    description VARCHAR(200) NOT NULL
);

CREATE TABLE SnortParameter (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_snortPreprocessor INTEGER NOT NULL,
    name VARCHAR(20) NOT NULL,
    description VARCHAR(200) NOT NULL,
    separator CHAR(1) NOT NULL,
    boundarys CHAR(4) NOT NULL,
    CONSTRAINT snortpreprocessor_snortparameter_fk FOREIGN KEY (id_snortPreprocessor) REFERENCES SnortPreprocessor (id)
);

CREATE TABLE Snort (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    rulesDirectory VARCHAR(100) NOT NULL,
    dynamicengine VARCHAR(100) NOT NULL,
    dynamicpreprocessor VARCHAR(100) NOT NULL,
    dynamicdetection VARCHAR(100) NOT NULL,
    limitedResources BOOLEAN NOT NULL,
    enable BOOLEAN NOT NULL,
    id_interface_external INTEGER NOT NULL,
    id_interface_internal INTEGER NOT NULL,
    createdDate DATE NOT NULL,
    id_account_creator INTEGER NOT NULL,
    modifiedDate DATE NOT NULL,
    id_account_modifier INTEGER NOT NULL,
    lastApplyDate DATE NOT NULL,
    id_account_apply INTEGER NOT NULL,
    logDirectory VARCHAR(100) NOT NULL,
    CONSTRAINT interface_internal_snort_fk FOREIGN KEY (id_interface_internal) REFERENCES Interface (id),
    CONSTRAINT interface_external_snort_fk FOREIGN KEY (id_interface_external) REFERENCES Interface (id),
    CONSTRAINT account_creator_snort_fk FOREIGN KEY (id_account_creator) REFERENCES Account (id),
    CONSTRAINT account_apply_snort_fk FOREIGN KEY (id_account_apply) REFERENCES Account (id),
    CONSTRAINT account_modifier_snort_fk FOREIGN KEY (id_account_modifier) REFERENCES Account (id)
);

CREATE TABLE SnortRule (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_snort INTEGER NOT NULL,
    id_snortAction INTEGER NOT NULL,
    id_protocol INTEGER NOT NULL,
    startIP VARCHAR(44) NOT NULL,
    startPort VARCHAR(15) NOT NULL,
    id_direction INTEGER NOT NULL,
    endIP VARCHAR(44) NOT NULL,
    endPort VARCHAR(15) NOT NULL,
    CONSTRAINT snortdirection_snortrule_fk FOREIGN KEY (id_direction) REFERENCES SnortDirection (id),
    CONSTRAINT snortaction_snortrule_fk FOREIGN KEY (id_snortAction) REFERENCES SnortAction (id),
    CONSTRAINT protocol_snortrule_fk FOREIGN KEY (id_protocol) REFERENCES Protocol (id),
    CONSTRAINT snort_snortrule_fk FOREIGN KEY (id_snort) REFERENCES Snort (id)
);

CREATE TABLE SnortOption_x_Rule (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_snortOption INTEGER NOT NULL,
    id_snortRule INTEGER NOT NULL,
    value VARCHAR(20) NOT NULL,
    CONSTRAINT snortoption_snortoption_x_rule_fk FOREIGN KEY (id_snortOption) REFERENCES SnortOption (id),
    CONSTRAINT snortrule_snortoption_x_rule_fk FOREIGN KEY (id_snortRule) REFERENCES SnortRule (id)
);

CREATE TABLE Snort_x_Parameter_x_Preprocessor (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_snort INTEGER NOT NULL,
    id_snortParameter INTEGER NOT NULL,
    id_snortPreprocessor INTEGER NOT NULL,
    value VARCHAR(200) NOT NULL,
    CONSTRAINT snortpreprocessor_snort_x_parameter_x_preprocessor_fk FOREIGN KEY (id_snortPreprocessor) REFERENCES SnortPreprocessor (id),
    CONSTRAINT snortparameter_snort_x_parameter_x_preprocessor_fk FOREIGN KEY (id_snortParameter) REFERENCES SnortParameter (id),
    CONSTRAINT snort_snort_x_parameter_x_preprocessor_fk FOREIGN KEY (id_snort) REFERENCES Snort (id)
);

CREATE TABLE Snort_x_PredefinedRule (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_snort INTEGER NOT NULL,
    id_snortPredefinedRule INTEGER NOT NULL,
    CONSTRAINT snortpredefinedrule_snort_x_predefinedrule_fk FOREIGN KEY (id_snortPredefinedRule) REFERENCES SnortPredefinedRule (id),
    CONSTRAINT snort_snort_x_predefinedrule_fk FOREIGN KEY (id_snort) REFERENCES Snort (id)
);

CREATE TABLE Snort_x_Node (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_snort INTEGER NOT NULL,
    id_node INTEGER NOT NULL,
    CONSTRAINT node_snort_x_node_fk FOREIGN KEY (id_node) REFERENCES Node (id),
    CONSTRAINT snort_snort_x_node_fk FOREIGN KEY (id_snort) REFERENCES Snort (id)
);


