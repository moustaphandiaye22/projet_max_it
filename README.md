# MaxIT SA - Système de Gestion Financière

## 📋 Description
MaxIT SA est un système de gestion financière développé en PHP qui permet la gestion de comptes bancaires, de transactions et d'intégrations avec des services externes comme Woyofal pour les achats de codes électriques.
## 🛠️ user
login : mndiaye
password : pass123

login:admin
paswword : admin


## 🚀 Fonctionnalités

### Gestion des Comptes
- **Comptes principaux** : Comptes téléphoniques avec solde
- **Comptes secondaires** : Sous-comptes liés aux comptes principaux
- **Gestion des soldes** : Suivi en temps réel des soldes
- **Historique** : Consultation de l'historique des comptes

### Transactions
- **Dépôts** : Ajout de fonds aux comptes
- **Transferts** : Transfert entre comptes
- **Retraits** : Retrait de fonds
- **Paiements Woyofal** : Achat de codes électriques via API externe

### Intégrations Externes
- **API Woyofal** : Intégration pour l'achat de codes électriques
- **API Daff** : Intégration pour la recuperation des numero de carte d'identite  des citoyen depuis la daff
- **Système de notifications** : Gestion des alertes

## 🏗️ Architecture

### Structure MVC
```
src/
├── Entity/          # Entités métier (Compte, Transaction, Personne)
├── Controller/      # Contrôleurs (gestion des requêtes)
├── Service/         # Services métier (logique applicative)
├── Repository/      # Accès aux données (DAO)
└── Database/        # Configuration base de données

app/
├── Core/           # Noyau de l'application
└── Config/         # Configuration

templates/          # Vues (templates PHP)
routes/            # Configuration des routes
public/            # Assets publics
```

### Entités Principales

#### Compte
- `id` : Identifiant unique
- `solde` : Solde du compte (FCFA)
- `numero_telephone` : Numéro de téléphone associé
- `type` : Type de compte (principal/secondaire)
- `personne` : Propriétaire du compte
- `transactions` : Historique des transactions

#### Transaction
- `id` : Identifiant unique
- `reference` : Référence de transaction
- `montant` : Montant (FCFA)
- `type` : Type (dépôt, retrait, transfert, woyofal)
- `compte` : Compte associé
- `datetransaction` : Date/heure de la transaction

## 🛠️ Installation

### Prérequis
- PHP 8.0+
- Composer
- MySQL/MariaDB
- Docker (optionnel)

### Installation locale
```bash
# Cloner le repository
git clone https://github.com/moustaphandiaye22/projet_max_it.git
cd projet_max_it

# Installer les dépendances
composer install

# Configuration de la base de données
cp .env.example .env
# Éditer .env avec vos paramètres de DB

# Migrations
composer run database:migrate

# Seeders (données de test)
composer run database:seed
```

### Installation Docker
```bash
# Démarrer avec Docker Compose
docker-compose up -d

# Accéder à l'application
http://localhost:8080
```

## 🔧 Configuration

### Variables d'environnement (.env)
```env
DB_HOST=localhost
DB_NAME=maxitsa_db
DB_USER=root
DB_PASS=

# API Woyofal
WOYOFAL_API_URL=https://appwoyofal-zfte.onrender.com
```

### Scripts Composer
```bash
# Migration de la base de données
composer run database:migrate

# Insertion des données de test
composer run database:seed
```

## 📊 API Woyofal

### Achat de code électrique
**Endpoint** : `POST /transactions/achat_woyofal`

**Payload** :
```json
{
  "numerocompteur": "123456789",
  "montant": 5000
}
```

**Réponse** :
```json
{
  "statut": "success",
  "message": "Achat réussi",
  "data": {
    "client": "Nom du client",
    "compteur": "123456789",
    "code": "1234-5678-9012",
    "nbreKwt": "25.5",
    "tranche": "T1",
    "prix": "196",
    "reference": "REF123",
    "date": "2025-01-28 10:30:00"
  }
}
```

## 🧪 Tests

```bash
# Exécuter les tests (à implémenter)
php vendor/bin/phpunit tests/

# Tests d'intégration API
curl -X POST http://localhost:8080/transactions/achat_woyofal \
  -H "Content-Type: application/json" \
  -d '{"numerocompteur":"123456","montant":1000}'
```

## 📱 Interface Utilisateur

### Pages principales
- `/` : Page d'accueil
- `/login` : Connexion
- `/accueil` : Tableau de bord
- `/transactions/depot` : Formulaire de dépôt
- `/transactions/transfert` : Transfert de fonds
- `/transactions/achat_woyofal` : Achat code Woyofal

### Fonctionnalités JavaScript
- Validation côté client
- Appels AJAX vers API Woyofal
- Affichage dynamique des reçus
- Gestion des erreurs en temps réel

## 🔒 Sécurité

- Validation des données d'entrée
- Échappement des sorties HTML
- Sessions sécurisées
- Protection CSRF (à implémenter)
- Validation des montants et soldes

## 👥 Contributeurs

- **Moustapha Ndiaye** - Développeur principal
- Email: tziprincii434@gmail.com

## 📄 Licence

Ce projet est sous licence propriétaire MaxIT SA.

## 🔄 Roadmap

- [ ] Tests unitaires complets
- [ ] API REST complète
- [ ] Interface mobile
- [ ] Intégrations bancaires supplémentaires
- [ ] Système de notifications avancé
- [ ] Tableau de bord analytique
