<?php

namespace Mailery\Sender\Model;

use Mailery\Channel\Entity\Channel;
use Mailery\Channel\Model\ChannelTypeList;

class SenderTypeByChannelTypeMap
{

    /**
     * @param SenderTypeList $senderTypeList
     * @param ChannelTypeList $channelTypeList
     */
    public function __construct(
        private SenderTypeList $senderTypeList,
        private ChannelTypeList $channelTypeList
    ) {}

    /**
     * @param Channel $channel
     * @return SenderTypeInterface
     */
    public function get(Channel $channel): SenderTypeInterface
    {
        if (($channelType = $this->channelTypeList->findByEntity($channel)) === null) {
            return false;
        }

        return $this->senderTypeList->findByChannelType($channelType);
    }

}
