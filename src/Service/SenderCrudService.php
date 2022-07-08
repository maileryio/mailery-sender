<?php

declare(strict_types=1);

namespace Mailery\Sender\Service;

use Cycle\ORM\EntityManagerInterface;
use Mailery\Sender\Entity\Sender;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

class SenderCrudService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @param Sender $sender
     * @return bool
     */
    public function delete(Sender $sender): bool
    {
        (new EntityWriter($this->entityManager))->delete($sender);

        return true;
    }
}
