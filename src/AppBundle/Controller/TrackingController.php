<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Driver;
use AppBundle\Entity\Order;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

class TrackingController extends Controller
{
    public function indexAction()
    {

        $availableDriverCollection = $this->getDoctrine()
            ->getRepository('AppBundle:Driver')
            ->getAllAvailable();

        $orderRep = $this->getDoctrine()->getRepository('AppBundle:Order');

        foreach ($availableDriverCollection as $item) {
            $item->orderCount = count($orderRep->getDriverActiveOrderCollection($item));
        }

        $activeOrderCollection = $orderRep->getCurrentlyActive();

        return $this->render('AppBundle:Tracking:index.html.twig', [
            'availableDriverCollection' => $availableDriverCollection,
            'activeOrderCollection' => $activeOrderCollection,
            'MAP_API_KEY' => $this->getParameter('map_api_key')
        ]);
    }

    public function orderAction(Request $request)
    {
        $order = new Order();
        $order->setStatus(Order::STATUS_ASSIGNED);
        $order->setDateCreated(new \DateTime());
        $form = $this->createFormBuilder($order);
        $form->add('driver', EntityType::class, [
            'class' => 'AppBundle:Driver',
            'choice_label' => function(Driver $driver) {
                $orderRep = $this->getDoctrine()->getRepository('AppBundle:Order');
                return $driver->getName().' ('.count($orderRep->getDriverActiveOrderCollection($driver)).')';
            },
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('d')
                    ->where('d.isWorking = 1')
                    ->orderBy('d.name', 'ASC');
            },
        ]);
        $form->add('pickup_address', TextType::class, [
            'constraints' => [
                new NotBlank(),
            ]
        ]);
        $form->add('pickup_latitude', HiddenType::class);
        $form->add('pickup_longitude', HiddenType::class);
        $form->add('destination_address', TextType::class,[
            'constraints' => [
                new NotBlank()
            ]
        ]);
        $form->add('destination_latitude', HiddenType::class);
        $form->add('destination_longitude', HiddenType::class);
        $form->add('name', TextType::class, [
            'label' => 'Client name',
            'constraints' => [
                new NotBlank(),
            ]
        ]);
        $form->add('phone',TextType::class, [
            'label' => 'Client phone',
            'constraints' => [
                new NotBlank(),
            ]
        ]);
        $form->add('comment', TextareaType::class);

        $formBuilder = $form->getForm();
        $formBuilder->handleRequest($request);
        if ($formBuilder->isSubmitted() && $formBuilder->isValid()) {

            try {
                $data = $formBuilder->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();
                return new JsonResponse(['success' => true]);
            } catch (\Exception $e){
                echo $e->getMessage();
            }

        }

        $availableDriverCollection = $this->getDoctrine()
            ->getRepository('AppBundle:Driver')
            ->getAllAvailable();

        return $this->render('@App/Tracking/order.html.twig', [
            'form' => $formBuilder->createView(),
            'availableDriverCollection' => $availableDriverCollection
        ]);
    }

    public function trackAction(Request $request)
    {

        $response = ['success' => true, 'content' => null];

        $type = $request->request->get('type', 'driver');
        $id = (int) $request->request->get('id', 0);

        try {
            $driverRep = $this->getDoctrine()->getRepository('AppBundle:Driver');
            $orderRep = $this->getDoctrine()->getRepository('AppBundle:Order');
            switch ($type) {
                case "driver":

                    $driver = $driverRep->find($id);
                    if(!$driver) {
                        throw new \Exception('Driver not found');
                    }
                    $response['content'] = $this->get('AppBundle\Service\DriverService')->getCurrentContent($driver);
                    $response['route'] = $orderRep->findStopPoint($driver);
                    break;
                default:

                    $order = $orderRep->find($id);
                    if(!$order) {
                        throw new \Exception('Order not found');
                    }
                    $response['content'] = $this->get('AppBundle\Service\CustomerService')->getCurrentContent($order);
                    $response['route'] = $orderRep->findStopPoint($order->getDriver());

                    break;
            }


        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = false;
        }

        return new JsonResponse($response);
    }

    public function orderStatusAction(Request $request)
    {
        $response = ['success' => true];
        $t = $this->get('translator');
        $id = (int) $request->request->get('id');
        $status = $request->request->get('status');

        try {
            if (!in_array($status, [Order::STATUS_PICKED, Order::STATUS_CANCELED, Order::STATUS_FINISHED])) {
                throw new \Exception($t->trans('Status not found'));
            }

            $order = $this->getDoctrine()->getRepository('AppBundle:Order')->find($id);
            if(!$order) {
                throw new \Exception($t->trans('Order not found'));
            }

            $order->setStatus($status);
            $order->setDateUpdated(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            $response['success'] = false;
        }

        return new JsonResponse($response);
    }

    public function updateMarkerAction(Request $request)
    {
        $response = ['success' => true, 'ts' => null];

        try {




            $response['ts'] = time();
        } catch (\Exception $e){
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }

        return new JsonResponse($response);
    }
}
