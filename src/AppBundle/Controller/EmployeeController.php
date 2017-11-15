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

        if($edit && $obj) {
            $editObj = clone $obj;
        }

        $t = $this->get('translator');
        $form = $this->createForm('AppBundle\Form\EmployeeType', $obj, ['edit' => $edit]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var $usr User
             */
            $usr = $form->getData();

            if(empty($usr->getPassword())) {
                $usr->setPassword($editObj->getPassword());
            } else {
                $encoder = $this->get('security.encoder_factory')->getEncoder($usr);
                $usr->setPassword($encoder->encodePassword($usr->getPassword(), $usr->getSalt()));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($usr);
            $em->flush();
            $this->addFlash('success', $t->trans($edit ? "Successfully updated" : "Successfully created"));
            return $this->redirectToRoute('employee_form', array('id' => $usr->getId()));
        }

        return $this->render('@App/Employee/form.html.twig', [
            'obj' => $obj,
            'edit' => $edit,
            'form' => $form->createView(),
        ]);
    }

}
