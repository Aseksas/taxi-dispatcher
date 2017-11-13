<?php
namespace  AppBundle\Service;

use AppBundle\Entity\Driver;
use AppBundle\Entity\Order;
use Symfony\Bundle\TwigBundle\TwigEngine;


class CustomerService
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

    public function getCurrentContent(Order $order)
    {

        return $this->template->render('@App/Block/customer.html.twig', [
            'order' => $order
        ]);
    }

}