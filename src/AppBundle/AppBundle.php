<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getMenu()
    {
        $t = $this->container->get('translator');

        return [
            'tracking' => [
                'name' => $t->trans('Tracking'),
                'route' => 'tracking_index',
                'roles' => ['ROLE_ADMIN', 'ROLE_USER'],
                'child' => []
            ]
        ];
    }
}
