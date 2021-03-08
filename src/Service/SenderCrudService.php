<?php

declare(strict_types=1);

namespace Mailery\Sender\Service;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;
use Mailery\Sender\Entity\Sender;

class SenderCrudService
{
    /**
     * @var ORMInterface
     */
    private ORMInterface $orm;

    /**
     * @param ORMInterface $orm
     */
    public function __construct(ORMInterface $orm)
    {
        $this->orm = $orm;
    }

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
