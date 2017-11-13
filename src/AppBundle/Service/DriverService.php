<?php
namespace  AppBundle\Service;

use AppBundle\Entity\Driver;
use Symfony\Bundle\TwigBundle\TwigEngine;


class DriverService
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var TwigEngine
     */
    private $template;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager, TwigEngine $template)
    {
        $this->em = $entityManager;
        $this->template = $template;
    }

    public function getCurrentContent(Driver $driver)
    {
        $orderCollection =$this->em
            ->getRepository('AppBundle:Order')
            ->getDriverActiveOrderCollection($driver);

        return $this->template->render('@App/Block/driver.html.twig', [
            'driver' => $driver,
            'orderCollection' => $orderCollection
        ]);
    }

}