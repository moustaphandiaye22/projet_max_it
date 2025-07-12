<?php
namespace app\config;

 enum ErrorMessage: string
 {
    case required = 'Ce champ est obligatoire';
    case invalidEmail = 'L\'email est invalide';
    case invalidPhone = 'Le numéro de téléphone est invalide';
    case invalidLength = 'La longueur du champ est invalide';
    case invalidPassword = 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial';
    case invalidCni = 'Le numéro de CNI est invalide';
    case phoneExists = 'Ce numéro de téléphone existe déjà';
    case cniExists = 'Ce numéro CNI existe déjà';
    case photo = 'La photo est invalide';
    case photoRequired = 'La photo est obligatoire';
    case termsNotAccepted = 'Vous devez accepter les termes d\'utilisation';
    case uploadError = 'Erreur lors du téléchargement de l\'image';
    case accountCreationError = 'Erreur lors de la création du compte';
    case transactionError = 'Erreur lors de la création de la transaction';
    case insufficientBalance = 'Solde insuffisant pour effectuer cette transaction';
    case accountNotFound = 'Compte non trouvé';
    case personNotFound = 'Personne non trouvée';
    case transactionNotFound = 'Transaction non trouvée';
    case invalidAmount = 'Le montant doit être supérieur à zéro';
    case invalidAccountType = 'Type de compte invalide';
    case invalidCredentials = 'Identifiants invalides';
    case accountAlreadyExists = 'Un compte existe déjà pour cette personne';
    case accountCreationSuccess = 'Compte créé avec succès';
    case transactionSuccess = 'Transaction effectuée avec succès';
    case loginRequired = 'Vous devez être connecté pour accéder à cette page';
    case logoutSuccess = 'Déconnexion réussie';
    case registrationSuccess = 'Inscription réussie, vous pouvez maintenant vous connecter';
 }