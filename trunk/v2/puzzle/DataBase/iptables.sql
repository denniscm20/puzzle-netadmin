CREATE TABLE IptablesStatus (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(15) NOT NULL
);

CREATE TABLE IptablesPolicy (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(6) NOT NULL
);


CREATE TABLE IptablesAction (
    id INTEGER NOT NULL,
    name VARCHAR(10) NOT NULL
);

CREATE TABLE IptablesPredefinedRule (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    description VARCHAR(200) NOT NULL
);

CREATE TABLE IptablesTable (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(6) NOT NULL
);

CREATE TABLE IptablesChain (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_iptablesTable INTEGER NOT NULL,
    name VARCHAR(15) NOT NULL,
    CONSTRAINT iptablestable_iptableschain_fk FOREIGN KEY (id_iptablesTable) REFERENCES IptablesTable (id)
);

CREATE TABLE Iptables (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    description VARCHAR(100) NOT NULL,
    logfile VARCHAR(100) NOT NULL,
    enable BOOLEAN NOT NULL,
    createdDate DATE NOT NULL,
    id_account_creator INTEGER NOT NULL,
    modifiedDate DATE NOT NULL,
    id_account_modifier INTEGER NOT NULL,
    lastApplyDate DATE NOT NULL,
    id_account_apply INTEGER NOT NULL,
    CONSTRAINT account_creator_iptables_fk FOREIGN KEY (id_account_creator) REFERENCES Account (id),
    CONSTRAINT account_modifier_iptables_fk FOREIGN KEY (id_account_modifier) REFERENCES Account (id),
    CONSTRAINT account_apply_iptables_fk FOREIGN KEY (id_account_apply) REFERENCES Account (id)
);

CREATE TABLE IptablesPredefinedRule_x_IptablesRule (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_iptablesPredefinedRule INTEGER NOT NULL,
    id_iptablesRule INTEGER NOT NULL,
    CONSTRAINT iptablespredefinedrule_iptablespredefinedrule_x_iptablesrule_fk FOREIGN KEY (id_iptablesPredefinedRule) REFERENCES IptablesPredefinedRule (id),
    CONSTRAINT iptablesrule_iptablespredefinedrule_x_iptablesrule_fk FOREIGN KEY (id_iptablesRule) REFERENCES IptablesRule (id)
);

CREATE TABLE IptablesRule (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_iptables INTEGER NOT NULL,
    id_iptablesChain INTEGER NOT NULL,
    id_iptablesAction INTEGER NOT NULL,
    id_interfaceIn INTEGER NOT NULL,
    id_interfaceOut INTEGER NOT NULL,
    id_protocol INTEGER NOT NULL,
    dportStart SMALLINTEGER NOT NULL,
    dportEnd SMALLINTEGER NOT NULL,
    sportStart SMALLINTEGER NOT NULL,
    sportEnd SMALLINTEGER NOT NULL,
    sipStart VARCHAR(15) NOT NULL,
    sipEnd VARCHAR(15) NOT NULL,
    dipStart VARCHAR(15) NOT NULL,
    dipEnd VARCHAR(15) NOT NULL,
    log BOOLEAN NOT NULL,
    CONSTRAINT iptablesaction_iptablesrule_fk FOREIGN KEY (id_iptablesAction) REFERENCES IptablesAction (id),
    CONSTRAINT protocol_iptablesrule_fk FOREIGN KEY (id_protocol) REFERENCES Protocol (id),
    CONSTRAINT iptableschain_iptablesrule_fk FOREIGN KEY (id_iptablesChain) REFERENCES IptablesChain (id),
    CONSTRAINT interfacein_iptablesrule_fk FOREIGN KEY (id_interfaceIn) REFERENCES Interface (id),
    CONSTRAINT interfaceout_iptablesrule_fk FOREIGN KEY (id_interfaceOut) REFERENCES Interface (id),
    CONSTRAINT iptables_iptablesrule_fk FOREIGN KEY (id_iptables) REFERENCES Iptables (id)
);

CREATE TABLE IptablesRule_x_Status (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_iptablesStatus INTEGER NOT NULL,
    id_iptablesRule INTEGER NOT NULL,
    CONSTRAINT iptablesstatus_iptablesrule_x_status_fk FOREIGN KEY (id_iptablesStatus) REFERENCES IptablesStatus (id),
    CONSTRAINT iptablesrule_iptablesrule_x_status_fk FOREIGN KEY (id_iptablesRule) REFERENCES IptablesRule (id)
);

CREATE TABLE Iptables_x_Chain_x_Policy (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_iptables INTEGER NOT NULL,
    id_iptablesPolicy INTEGER NOT NULL,
    id_iptablesChain INTEGER NOT NULL,
    CONSTRAINT iptablespolicy_iptableschain_x_iptables_x_policy_fk FOREIGN KEY (id_iptablesPolicy) REFERENCES IptablesPolicy (id),
    CONSTRAINT iptableschain_iptableschain_x_iptables_x_policy_fk FOREIGN KEY (id_iptablesChain) REFERENCES IptablesChain (id),
    CONSTRAINT iptables_iptableschain_x_iptables_x_policy_fk FOREIGN KEY (id_iptables) REFERENCES Iptables (id)
);

CREATE TABLE Iptables_x_Table_x_Action (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_iptablesAction INTEGER NOT NULL,
    id_iptablesTable INTEGER NOT NULL,
    id_iptables INTEGER NOT NULL,
    CONSTRAINT iptablesaction_iptablestable_x_iptables_x_action_fk FOREIGN KEY (id_iptablesAction) REFERENCES IptablesAction (id),
    CONSTRAINT iptables_iptablestable_x_iptables_x_action_fk FOREIGN KEY (id_iptables) REFERENCES Iptables (id),
    CONSTRAINT iptablestable_iptablestable_x_iptables_x_action_fk FOREIGN KEY (id_iptablesTable) REFERENCES IptablesTable (id)
);

CREATE TABLE Iptables_x_PredefinedRule_x_Action (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_iptablesAction INTEGER NOT NULL,
    id_iptablesPredefinedRule INTEGER NOT NULL,
    id_iptables INTEGER NOT NULL,
    CONSTRAINT iptablesaction_iptablespredefinedrule_x_iptables_x_action_fk FOREIGN KEY (id_iptablesAction) REFERENCES IptablesAction (id),
    CONSTRAINT iptablespredefinedrule_iptablespredefinedrule_x_iptables_x_action_fk FOREIGN KEY (id_iptablesPredefinedRule) REFERENCES IptablesPredefinedRule (id),
    CONSTRAINT iptables_iptablespredefinedrule_x_iptables_x_action_fk FOREIGN KEY (id_iptables) REFERENCES Iptables (id)
);


