CREATE TABLE Nmap (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    scanDate TIMESTAMP NOT NULL,
    id_account_scanner INTEGER NOT NULL,
    options VARCHAR(20) NOT NULL,
    CONSTRAINT account_nmap_fk FOREIGN KEY (id_account_scanner) REFERENCES Account (id)
);


