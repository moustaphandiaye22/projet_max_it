CREATE TYPE type_personne AS ENUM ('client', 'servicecommercial');
CREATE TYPE type_compte AS ENUM ('principal', 'secondaire');
CREATE TYPE type_transaction AS ENUM ('depot', 'retrait', 'paiement');

CREATE TABLE personne (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    adresse TEXT,
    numero_telephone VARCHAR(20) UNIQUE NOT NULL,
    login VARCHAR(100) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    photo_recto_carte_identite TEXT,
    photo_verso_carte_identite TEXT,
    numero_carte_identite VARCHAR(50),
    type type_personne NOT NULL
);
CREATE TABLE compte (
    id SERIAL PRIMARY KEY,
    numero_telephone VARCHAR(20) UNIQUE NOT NULL,
    solde DOUBLE PRECISION DEFAULT 0,
    date_creation DATE NOT NULL DEFAULT CURRENT_DATE,
    type type_compte NOT NULL,
    client_id INT NOT NULL,
    FOREIGN KEY (client_id) REFERENCES personne(id)
);
CREATE TABLE transaction (
    id SERIAL PRIMARY KEY,
    reference VARCHAR(100) UNIQUE NOT NULL,
    montant FLOAT NOT NULL CHECK (montant >= 0),
    date_transaction DATE NOT NULL DEFAULT CURRENT_DATE,
    type type_transaction NOT NULL,
    compte_id INT NOT NULL,
    FOREIGN KEY (compte_id) REFERENCES compte(id)
);

INSERT INTO personne (nom, prenom, adresse, numero_telephone, login, password, photo_recto_carte_identite, photo_verso_carte_identite, numero_carte_identite, type)
VALUES
('Ndiaye', 'Moustapha', 'Dakar', '771234567', 'mndiaye', 'pass123', 'recto1.jpg', 'verso1.jpg', 'SN123456', 'client'),
('Ba', 'Aminata', 'Thiès', '770987654', 'aba', 'pass456', 'recto2.jpg', 'verso2.jpg', 'SN789012', 'servicecommercial');

INSERT INTO compte (numero_telephone, solde, date_creation, type, client_id)
VALUES
('771234567', 50000.00, CURRENT_DATE, 'principal', 1),
('770987654', 150000.00, CURRENT_DATE, 'secondaire', 1);
