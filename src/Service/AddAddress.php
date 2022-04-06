<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class AddAddress
{
    private $addAddress;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, $addAddress)
    {
        $this->addAddress = $addAddress;
        $this->entityManager = $entityManager;

    }

    public function addAddress($addressline1,$addressline2,$addressline3,$addressline4,$addressline5,$latitude,$longitude)
    {
        $em = $this->entityManager;
        $RAW_QUERY = "INSERT INTO address(addressline1,addressline2,addressline3,addressline4,addressline5,latitude,longitude) VALUES ('$addressline1','$addressline2','$addressline3','$addressline4','$addressline5','$latitude','$longitude')";         
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
    }

    public function postAddAddress()
    {
        return $this->addAddress;
    }

}