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

  
    

}