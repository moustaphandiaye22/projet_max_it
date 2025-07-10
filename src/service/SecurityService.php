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
        return $this->personneRepository->SelectByLoginAndPassword($login, $password);
    }
    public function creerCompte(Personne $personne) {
        return $this->personneRepository->insert($personne);
    }
}
