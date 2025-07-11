<?php
namespace src\controller;

use src\service\PersonneService;
use src\entity\Personne;

class PersonneController {
    private PersonneService $personneService;

    public function __construct()
    {
        $this->personneService = new PersonneService(new \src\repository\PersonneRepository());
    }

    
}
