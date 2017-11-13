<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller
{

    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        if($this->getUser()) {
            return $this->redirect($this->generateUrl("tracking_index"));
        }

        return $this->render('@App/User/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    public function logoutAction(){}

    public function profileAction(Request $request)
    {
        $t = $this->get('translator');

        $userObj = $this->getDoctrine()->getRepository('AppBundle:User')->find($this->getUser()->getId());

        $formBuilder = $this->createFormBuilder($userObj);
        $formBuilder->add('username', null, ['disabled' => true]);
        $formBuilder->add('email');
        $formBuilder->add('password', RepeatedType::class, array(
        'type' => PasswordType::class,
        'invalid_message' => 'The password fields must match.',
        'options' => ['attr' => ['class' => 'password-field']],
        'required' => false,
        'first_options'  => ['label' => 'Password'],
        'second_options' => ['label' => 'Repeat Password'],
    ));
        $formBuilder->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-success']]);

        $form = $formBuilder->getForm();
        $userOldData = clone $userObj;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var User $user */
            $user = $form->getData();
            if(empty($user->getPassword())) {
                $user->setPassword($userOldData->getPassword());
            } else {
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
            }

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', $t->trans('Profile successfully updated'));
            $this->redirectToRoute('user_profile');
        }


        return $this->render('@App/User/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}