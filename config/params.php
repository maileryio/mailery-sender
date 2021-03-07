<?php

return [
    'yiisoft/yii-cycle' => [
        'annotated-entity-paths' => [
            '@vendor/maileryio/mailery-sender/src/Entity',
        ],
    ],

    'maileryio/mailery-menu-sidebar' => [
        'items' => [
            'senders' => [
                'label' => static function () {
                    return 'Senders';
                },
                'icon' => 'at',
                'items' => [],
            ],
        ],
    ],
];
