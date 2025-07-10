<?php
namespace src\service;
use src\repository\PersonneRepository;
use src\entity\Personne;

class PersonneService {

    private $personneRepository;

    public function __construct(PersonneRepository $personneRepository)
    {
        $this->personneRepository = $personneRepository;
    }

    public function seConnecter(string $login, string $password): ?Personne
    {
        return $this->personneRepository->SelectByLoginAndPassword($login, $password);
    }
    

}