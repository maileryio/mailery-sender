<?php

namespace Mailery\Sender\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Mailery\Sender\Model\SenderTypeInterface;

final class SenderTypeList extends ArrayCollection
{
    /**
     * @param object $sender
     * @return SenderTypeInterface|null
     */
    public function findByEntity(object $sender): ?SenderTypeInterface
    {
        return $this->filter(function (SenderTypeInterface $senderType) use($sender) {
            return $senderType->isEntitySameType($sender);
        })->first() ?: null;
    }
}
