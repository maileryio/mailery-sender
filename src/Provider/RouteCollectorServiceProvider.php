<?php

namespace Mailery\Sender\Provider;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Router\RouteCollectorInterface;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Mailery\Sender\Controller\DefaultController;

final class RouteCollectorServiceProvider extends ServiceProvider
{
    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function register(ContainerInterface $container): void
    {
        /** @var RouteCollectorInterface $collector */
        $collector = $container->get(RouteCollectorInterface::class);

        $collector->addGroup(
            Group::create('/brand/{brandId:\d+}')
                ->routes(
                    Route::get('/senders')
                        ->name('/sender/default/index')
                        ->action([DefaultController::class, 'index']),
                    Route::delete('/sender/default/delete/{id:\d+}')
                        ->name('/sender/default/delete')
                        ->action([DefaultController::class, 'delete'])
            )
        );
    }
}
