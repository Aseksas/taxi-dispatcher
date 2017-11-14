<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmployeeController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Employee:index.html.twig', array(
            // ...
        ));
    }

    public function formAction()
    {
        return $this->render('AppBundle:Employee:form.html.twig', array(
            // ...
        ));
    }

    public function deleteAction()
    {
        return $this->render('AppBundle:Employee:delete.html.twig', array(
            // ...
        ));
    }

}
