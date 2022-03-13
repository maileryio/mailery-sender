<?php

use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Definitions\DynamicReference;
use Mailery\Sender\Entity\Sender;

return [
    'yiisoft/yii-cycle' => [
        'entity-paths' => [
            '@vendor/maileryio/mailery-sender/src/Entity',
        ],
    ],

    'maileryio/mailery-activity-log' => [
        'entity-groups' => [
            'sender' => [
                'label' => DynamicReference::to(static fn () => 'Sender'),
                'entities' => [
                    Sender::class,
                ],
            ],
        ],
    ],

    'maileryio/mailery-sender' => [
        'types' => [],
    ],

    'maileryio/mailery-menu-sidebar' => [
        'items' => [
            'senders' => [
                'label' => static function () {
                    return 'Senders';
                },
                'icon' => 'at',
                'items' => [
                    'senders' => [
                        'label' => static function () {
                            return 'All Senders';
                        },
                        'url' => static function (UrlGeneratorInterface $urlGenerator) {
                            return $urlGenerator->generate('/sender/default/index');
                        },
                    ],
                ],
                'activeRouteNames' => [
                    '/sender/default/index',
                ],
            ],
        ],
    ],
];
