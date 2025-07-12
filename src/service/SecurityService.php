<?php

namespace src\service;
use src\entity\Personne;
use src\repository\PersonneRepository;
use  src\repository\CompteRepository;
class SecurityService
{
    private $personneRepository;
    private $compteRepository;

    public function __construct(PersonneRepository $personneRepository, CompteRepository $compteRepository)
    {
        $this->personneRepository = $personneRepository;
        $this->compteRepository = $compteRepository;
    }

    public function seConnecter(string $login, string $password): ?Personne
    {
        $personne = $this->personneRepository->SelectByLogin($login);
        if ($personne && password_verify($password, $personne->getPassword())) {
            return $personne;
        }
        return null;
    }
    public function creerCompte(Personne $personne) {
        return $this->personneRepository->insertPersonne($personne);
    }
}
