<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Driver;
use AppBundle\Entity\Order;

class OrderRepository extends \Doctrine\ORM\EntityRepository
{
    public function getDriverActiveOrderCollection(Driver $driver)
    {
        $q = $this->createQueryBuilder('o');
        $q->where('o.driver = :driver');
        $q->andWhere($q->expr()->in('o.status', [Order::STATUS_ASSIGNED, Order::STATUS_PICKED]));
        $q->setParameter('driver', $driver);
        return $q->getQuery()->getResult();
    }

    public function getCurrentlyActive()
    {
        $q = $this->createQueryBuilder('o');
        $q->where($q->expr()->in('o.status', [Order::STATUS_NEW, Order::STATUS_ASSIGNED, Order::STATUS_PICKED]));
        return $q->getQuery()->getResult();
    }

    public function findStopPoint(Driver $driver)
    {
        $pointCollection = [];
        $pointCollection[] = ['lat' => $driver->getLatitude(), 'lng' => $driver->getLongitude()];
        $activeOrderCollection = $this->getDriverActiveOrderCollection($driver);
        if(count($activeOrderCollection)) {
            /**
             * @var $order Order
             */
            foreach ($activeOrderCollection as $order) {
                if($order->getStatus() != Order::STATUS_PICKED) {
                    $pointCollection[] = ['lat' => $order->getPickupLatitude(), 'lng' => $order->getPickupLongitude()];
                }
                $pointCollection[] = ['lat' => $order->getDestinationLatitude(), 'lng' => $order->getDestinationLongitude()];
            }
        }

        return $pointCollection;
    }
}
