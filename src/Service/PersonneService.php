<?php
namespace Src\Service;
use Src\Repository\PersonneRepository;
use Src\Entity\Personne;

class PersonneService {

    private $personneRepository;

    public function __construct(PersonneRepository $personneRepository)
    {
        $this->personneRepository = $personneRepository;
    }

  
    

}