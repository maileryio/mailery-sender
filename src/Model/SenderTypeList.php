<?php

namespace Mailery\Sender\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Mailery\Sender\Model\SenderTypeInterface;
use Mailery\Channel\Model\ChannelTypeInterface as ChannelType;

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

    /**
     * @param ChannelType $channelType
     * @return SenderTypeInterface|null
     */
    public function findByChannelType(ChannelType $channelType): ?SenderTypeInterface
    {
        return $this->filter(function (SenderTypeInterface $senderType) use($channelType) {
            return $senderType->canUseChannelType($channelType);
        })->first() ?: null;
    }
}
