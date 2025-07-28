<?php

namespace App\Migrations;

use App\Core\Database;

class Migration
{
    protected \PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    public function run(){
        $this->pdo->exec(
            // Types
            "DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_personne') THEN
                    CREATE TYPE type_personne AS ENUM ('client', 'servicecommercial');
                END IF;
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_compte') THEN
                    CREATE TYPE type_compte AS ENUM ('principal', 'secondaire');
                END IF;
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_transaction') THEN
                    CREATE TYPE type_transaction AS ENUM ('depot', 'retrait', 'paiement');
                END IF;
            END $$;

            CREATE TABLE IF NOT EXISTS personne (
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
            CREATE TABLE IF NOT EXISTS compte (
                id SERIAL PRIMARY KEY,
                numero_telephone VARCHAR(20) UNIQUE NOT NULL,
                solde DOUBLE PRECISION DEFAULT 0,
                date_creation DATE NOT NULL DEFAULT CURRENT_DATE,
                type type_compte NOT NULL,
                client_id INT NOT NULL,
                FOREIGN KEY (client_id) REFERENCES personne(id)
            );
            CREATE TABLE IF NOT EXISTS transaction (
                id SERIAL PRIMARY KEY,
                reference VARCHAR(100) UNIQUE NOT NULL,
                montant FLOAT NOT NULL CHECK (montant >= 0),
                date_transaction DATE NOT NULL DEFAULT CURRENT_DATE,
                type type_transaction NOT NULL,
                compte_id INT NOT NULL,
                FOREIGN KEY (compte_id) REFERENCES compte(id)
            );"
        );
    }
}
