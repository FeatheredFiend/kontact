<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class AddInfection
{
    private $addInfection;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, $addInfection)
    {
        $this->addInfection = $addInfection;
        $this->entityManager = $entityManager;

    }

    public function addInfection($client,$disease,$infectiontest,$infectiondate)
    {
        $em = $this->entityManager;
        $RAW_QUERY = "INSERT INTO infection(client_id,disease_id,infectiontest_id,infectiondate) VALUES ('$client','$disease','$infectiontest','$infectiondate')";         
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
    }

    public function postAddInfection()
    {
        return $this->addInfection;
    }

}