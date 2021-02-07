<?php

namespace Mailery\Sender\Provider;

use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Router\RouteCollectorInterface;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Mailery\Sender\Provider\Controller\DomainController;
use Mailery\Sender\Provider\Controller\SenderController;

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
                    // Senders:
                    Route::methods(['GET', 'POST'], '/senders', [SenderController::class, 'index'])
                        ->name('/sender/sender/index'),

                    // Domains:
                    Route::methods(['GET', 'POST'], '/domains', [DomainController::class, 'index'])
                        ->name('/sender/domain/index'),
                ]
            )
        );
    }
}
