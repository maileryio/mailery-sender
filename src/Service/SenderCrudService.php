<?php

declare(strict_types=1);

namespace Mailery\Sender\Service;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;
use Mailery\Sender\Entity\Sender;

class SenderCrudService
{
    /**
     * @param ORMInterface $orm
     */
    public function __construct(
        private ORMInterface $orm
    ) {}

    /**
     * @param Sender $sender
     * @return bool
     */
    public function delete(Sender $sender): bool
    {
        $tr = new Transaction($this->orm);
        $tr->delete($sender);
        $tr->run();

        return true;
    }
}
