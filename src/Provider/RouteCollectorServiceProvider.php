<?php

namespace Mailery\Sender\Provider;

use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Router\RouteCollectorInterface;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Mailery\Sender\Controller\DefaultController;

final class RouteCollectorServiceProvider extends ServiceProvider
{
    /**
     * @param Container $container
     * @return void
     */
    public function register(Container $container): void
    {
        /** @var RouteCollectorInterface $collector */
        $collector = $container->get(RouteCollectorInterface::class);

        $collector->addGroup(
            Group::create(
                '/brand/{brandId:\d+}',
                [
                    Route::get('/senders', [DefaultController::class, 'index'])
                        ->name('/sender/default/index'),
                    Route::delete('/sender/default/delete/{id:\d+}', [DefaultController::class, 'delete'])
                        ->name('/sender/default/delete'),
                ]
            )
        );
    }
}
