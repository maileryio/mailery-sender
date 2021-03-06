<?php

use Mailery\Sender\Repository\SenderRepository;
use Psr\Container\ContainerInterface;
use Cycle\ORM\ORMInterface;
use Mailery\Sender\Entity\Sender;

return [
    SenderRepository::class => static function (ContainerInterface $container) {
        return $container
            ->get(ORMInterface::class)
            ->getRepository(Sender::class);
    },
];
