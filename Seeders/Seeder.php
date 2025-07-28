<?php

namespace App\Seeders;

use App\Core\Database;
class Seeder
{
    protected \PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    public function run():void{
        $this->pdo->exec(
            "INSERT INTO personne (nom, prenom, adresse, numero_telephone, login, password, photo_recto_carte_identite, photo_verso_carte_identite, numero_carte_identite, type)
            VALUES ('ndiaye', 'tapha', 'dakar', '773456789', 'tapha', 'tapha', 'recto.jpg', 'verso.jpg', '1234567890', 'client')
            ON CONFLICT (login) DO NOTHING;

            INSERT INTO personne (nom, prenom, adresse, numero_telephone, login, password, photo_recto_carte_identite, photo_verso_carte_identite, numero_carte_identite, type)
            VALUES ('lo', 'dane', 'dakar', '771000908', 'dane', 'dane', 'recto.jpg', 'verso.jpg', '1234567890', 'servicecommercial')
            ON CONFLICT (login) DO NOTHING;

            INSERT INTO compte (numero_telephone, solde, date_creation, type, client_id)
            VALUES ('773456789', 50000.00, CURRENT_DATE, 'principal', 1)
            ON CONFLICT (numero_telephone) DO NOTHING;

            INSERT INTO compte (numero_telephone, solde, date_creation, type, client_id)
            VALUES ('773456789', 50000.00, CURRENT_DATE, 'secondaire', 1)
            ON CONFLICT (numero_telephone) DO NOTHING;

            INSERT INTO transaction (reference, montant, date_transaction, type, compte_id)
            VALUES ('34567890', 50000.00, CURRENT_DATE, 'retrait', 1)
            ON CONFLICT (reference) DO NOTHING;

            INSERT INTO transaction (reference, montant, date_transaction, type, compte_id)
            VALUES ('4567890', 50000.00, CURRENT_DATE, 'depot', 1)
            ON CONFLICT (reference) DO NOTHING;

            INSERT INTO transaction (reference, montant, date_transaction, type, compte_id)
            VALUES ('567890', 50000.00, CURRENT_DATE, 'retrait', 1)
            ON CONFLICT (reference) DO NOTHING;

            INSERT INTO transaction (reference, montant, date_transaction, type, compte_id)
            VALUES ('67890', 50000.00, CURRENT_DATE, 'depot', 1)
            ON CONFLICT (reference) DO NOTHING;

            INSERT INTO transaction (reference, montant, date_transaction, type, compte_id)
            VALUES ('7890', 50000.00, CURRENT_DATE, 'retrait', 1)
            ON CONFLICT (reference) DO NOTHING;"
        );


    }
    

}
