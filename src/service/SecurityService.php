<?php

namespace src\service;
use src\entity\Personne;
use src\repository\PersonneRepository;
class SecurityService
{
    private $personneRepository;

    public function __construct(PersonneRepository $personneRepository)
    {
        $this->personneRepository = $personneRepository;
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
