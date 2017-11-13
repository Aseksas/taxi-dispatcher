<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Driver;

class DriverRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllAvailable()
    {
        $q =$this->createQueryBuilder('d');
        $q->where('d.isActive = 1');
        $q->andWhere('d.latitude IS NOT NULL');
        $q->andWhere('d.longitude IS NOT NULL');
        $q->andWhere('d.isWorking = 1');

        return $q->getQuery()->getResult();
    }

}
