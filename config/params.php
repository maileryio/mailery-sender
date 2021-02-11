<?php

use Yiisoft\Router\UrlGeneratorInterface;

return [
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
                            return $urlGenerator->generate('/sender/sender/index');
                        },
                    ],
                ],
            ],
        ],
    ],
];
