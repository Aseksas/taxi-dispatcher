<?php
namespace  AppBundle\Service;

use AppBundle\Entity\Driver;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;


class MenuService
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var \Symfony\Component\HttpKernel\Bundle\BundleInterface[]
     */
    private $bundleCollection;

    /**
     * @var mixed|\Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    private $security;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->bundleCollection = $this->container->get('kernel')->getBundles();
        $this->security = $this->container->get('security.authorization_checker');
    }

    public function build()
    {

        $menuCollection = [];

        foreach ($this->bundleCollection as $key => $bundle) {

            if(method_exists($bundle, 'getMenu')) {
                $menuBundle = $bundle->getMenu();
                $accessGranted = true;
                if(isset($menuBundle['roles']) && count($menuBundle['roles'])) {
                    $accessGranted = false;
                    foreach ($menuBundle['roles'] as $role) {
                        if($this->security->isGranted($role)) {
                            $accessGranted = true;
                            break;
                        }
                    }
                }
                if($accessGranted) {
                    $menuCollection = array_merge($menuCollection, $menuBundle);
                }
            }
        }

        return $menuCollection;
    }

}