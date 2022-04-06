<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Decommission
{
    private $decommission;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, $decommission)
    {
        $this->decommission = $decommission;
        $this->entityManager = $entityManager;

    }

    public function addDecommission($user, $tablename, $row)
    {
        $em = $this->entityManager;
        $RAW_QUERY = "INSERT INTO decommissioned(decommissioneddate, user_id, datatable_id, rownumber) VALUES (now(),'$user','$tablename','$row')";         
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
    }

    public function getDecommission()
    {
        return $this->decommission;
    }

}