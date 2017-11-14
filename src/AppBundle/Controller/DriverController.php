<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Driver;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Driver controller.
 *
 */
class DriverController extends Controller
{

    public function indexAction()
    {
        return $this->render('@App/Driver/index.html.twig', array(
            'drivers' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Driver')->findAll(),
        ));
    }

    public function formAction($id = null,Request $request)
    {
        $edit = true;
        $obj = $this->getDoctrine()->getRepository('AppBundle:Driver')->find($id ?:0);

        if(!$obj) {
            $edit = false;
            $obj = new Driver();
            $obj->setDateCreated(new \DateTime());
            $obj->setIsWorking(false);
        }
        $t = $this->get('translator');
        $form = $this->createForm('AppBundle\Form\DriverType', $obj);
        $form->remove('dateCreated');
        $form->remove('dateUpdated');
        $form->remove('latitude');
        $form->remove('longitude');
        $form->remove('isWorking');
        $form->remove('token');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($obj);
            $em->flush();
            $this->addFlash('success', $t->trans($edit ? "Successfully updated" : "Successfully created"));
            return $this->redirectToRoute('driver_form', array('id' => $obj->getId()));
        }

        return $this->render('@App/Driver/form.html.twig', [
            'obj' => $obj,
            'edit' => $edit,
            'form' => $form->createView(),
        ]);
    }


}
