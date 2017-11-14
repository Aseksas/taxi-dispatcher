<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DriverController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Driver:index.html.twig', array(
            // ...
        ));
    }

    public function formAction()
    {
        return $this->render('AppBundle:Driver:form.html.twig', array(
            // ...
        ));
    }

    public function deleteAction()
    {
        return $this->render('AppBundle:Driver:delete.html.twig', array(
            // ...
        ));
    }

}
