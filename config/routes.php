<?php

declare(strict_types=1);

use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Mailery\Sender\Controller\DefaultController;

return [
    Group::create('/brand/{brandId:\d+}')
        ->routes(
            Route::get('/senders')
                ->name('/sender/default/index')
                ->action([DefaultController::class, 'index']),
            Route::methods(['GET', 'POST'], '/sender/default/create')
                ->name('/sender/default/create')
                ->action([DefaultController::class, 'create']),
        )
];
