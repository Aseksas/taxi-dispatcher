<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmployeeController extends Controller
{
    public function indexAction()
    {
        return $this->render('@App/Employee/index.html.twig', array(
            'collection' => $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll(),
        ));
    }

    public function formAction($id = null, Request $request)
    {
        $edit = true;
        $obj = $this->getDoctrine()->getRepository('AppBundle:User')->find($id ?:0);

        if(!$obj) {
            $edit = false;
            $obj = new User();
        }
        $t = $this->get('translator');
        $form = $this->createForm('AppBundle\Form\EmployeeType', $obj);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($obj);
            $em->flush();
            $this->addFlash('success', $t->trans($edit ? "Successfully updated" : "Successfully created"));
            return $this->redirectToRoute('employee_form', array('id' => $obj->getId()));
        }

        return $this->render('@App/Employee/form.html.twig', [
            'obj' => $obj,
            'edit' => $edit,
            'form' => $form->createView(),
        ]);
    }

}
