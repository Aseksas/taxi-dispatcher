<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Driver;
use AppBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Driver controller.
 *
 */
class ApiController extends Controller
{

    public function loginAction($imei)
    {

        $response = ['success' => true, 'code' => 200];
        try {
            $driver = $this->getDoctrine()->getRepository('AppBundle:Driver')->findOneBy(['imei' => $imei]);
            if (!$driver) {
                throw new AccessDeniedHttpException('Driver not found');
            }

            $randToken = md5(microtime().'_'.$driver->getId().'-'.uniqid());

            $driver->setToken($randToken);
            $em = $this->getDoctrine()->getManager();
            $em->persist($driver);
            $em->flush();

            $response['token'] = $randToken;

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['code'] = $e->getCode();
            $response['message'] = $e->getMessage();
        }

        return new JsonResponse($response);
    }


    public function getAction(Request $request)
    {
        $response = ['success' => true, 'code' => 200];
        try {
            $driver = $this->getDriver($request);

            $b = $this->getDoctrine()
                ->getRepository('AppBundle:Order')
                ->createQueryBuilder('o');
            $b->where('o.driver = :driver');
            $b->andWhere($b->expr()->in('o.status', [Order::STATUS_ASSIGNED, Order::STATUS_PICKED]));
            $b->setParameter('driver', $driver->getId());
            $result = $b->getQuery()->getResult();
            $orderCollection = [];
            /**
             * @var $order Order
             */
            foreach ($result as $order) {

                $directionCollection = [];

                if($order->getStatus() != Order::STATUS_PICKED) {
                    $directionCollection['pickup'] = [
                        'address' => $order->getPickupAddress(),
                        'latitude' => $order->getPickupLatitude(),
                        'longitude' => $order->getPickupLongitude(),
                    ];
                }
                $directionCollection['destination'] = [
                    'address' => $order->getDestinationAddress(),
                    'latitude' => $order->getDestinationLatitude(),
                    'longitude' => $order->getDestinationLongitude(),
                ];

                $orderCollection[] = [
                    'id' => $order->getId(),
                    'name' => $order->getName(),
                    'phone' => $order->getComment(),
                    'comment' => $order->getComment(),
                    'direction' => $directionCollection,
                ];
            }
            $response['collection'] = $orderCollection;

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['code'] = $e->getCode();
            $response['message'] = $e->getMessage();
        }
        return new JsonResponse($response);
    }


    public function driverAction(Request $request)
    {
        $response = ['success' => true, 'code' => 200];
        try {

            $driver = $this->getDriver($request);

            if($request->request->has("working")) {
                $driver->setIsWorking($request->request->getBoolean("working"));
            }

            $driver->setLatitude($request->request->get('latitude'));
            $driver->setLongitude($request->request->get('longitude'));
            $driver->setDateUpdated(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($driver);
            $em->flush();

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['code'] = $e->getCode();
            $response['message'] = $e->getMessage();
        }
        return new JsonResponse($response);
    }

    public function updateAction(Request $request)
    {
        $response = ['success' => true];
        try {
            $driver = $this->getDriver($request);

            $order = $this->getDoctrine()
                ->getRepository('AppBundle:Order')
                ->findOneBy([
                    'driver' => $driver,
                    'id' => $request->request->get('id')
                ]);

            if(!$order) {
                throw new NotFoundHttpException('Order not found');
            }

            if(!in_array($order->getStatus(), [Order::STATUS_ASSIGNED, Order::STATUS_PICKED])) {
                throw new \HttpInvalidParamException('Order status cannot be changed.');
            }

            $status = $request->request->get('status');
            if(!in_array($status, [Order::STATUS_FINISHED, Order::STATUS_PICKED])) {
                throw new \HttpInvalidParamException('Status "'.$status.'" do not exist.');
            }

            $order->setStatus($status);
            $order->setDateUpdated(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['code'] = $e->getCode();
            $response['message'] = $e->getMessage();
        }

        return new JsonResponse($response);
    }

    /**
     * @param $request
     * @return Driver|null|object
     */
    private function getDriver($request)
    {
        $driver = $this->getDoctrine()
            ->getRepository('AppBundle:Driver')
            ->findOneBy([
                'token' => $request->headers->get('x-api-authorization')
            ]);

        if (!$driver) {
            throw new AccessDeniedHttpException('Wrong user token');
        }

        return $driver;
    }

}
