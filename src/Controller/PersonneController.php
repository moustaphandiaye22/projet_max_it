<?php
namespace Src\Controller;

use Src\Service\PersonneService;
use Src\Entity\Personne;

class PersonneController {
    private PersonneService $personneService;

    public function __construct()
    {
        $this->personneService = new PersonneService(new \Src\Repository\PersonneRepository());
    }

    
}
