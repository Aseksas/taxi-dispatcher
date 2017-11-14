<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getMenu()
    {
        $t = $this->container->get('translator');

        return [
            [
                'name' => $t->trans('Tracking'),
                'route' => 'tracking_index',
            ],
            [
                'name' => $t->trans('Driver'),
                'route' => 'driver_index',
                'roles' => ['ROLE_LOGISTIC']
            ],
            [
                'name' => $t->trans('Employee'),
                'route' => 'employee_index',
                'roles' => ['ROLE_ADMIN']
            ]
        ];
    }
}
