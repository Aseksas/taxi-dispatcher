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
                $menuBundleCollection = $bundle->getMenu();

                foreach ($menuBundleCollection as $menuItem) {
                    $accessGranted = true;
                    if(isset($menuItem['roles']) && count($menuItem['roles'])) {
                        $accessGranted = false;
                        foreach ($menuItem['roles'] as $role) {
                            if($this->security->isGranted($role)) {
                                $accessGranted = true;
                                break;
                            }
                        }
                    }
                    if($accessGranted) {
                        $menuCollection[] = $menuItem;
                    }
                }
            }
        }

        return $menuCollection;
    }

}