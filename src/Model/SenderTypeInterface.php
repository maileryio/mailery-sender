<?php

namespace Mailery\Sender\Model;

use Mailery\Sender\Entity\Sender;
use Mailery\Channel\Model\ChannelTypeInterface as ChannelType;

interface SenderTypeInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @return string
     */
    public function getCreateLabel(): string;

    /**
     * @return string|null
     */
    public function getCreateRouteName(): ?string;

    /**
     * @return array
     */
    public function getCreateRouteParams(): array;

    /**
     * @return ChannelType[]
     */
    public function getAvailChannelTypes(): array;

    /**
     * @param Sender $entity
     * @return bool
     */
    public function isEntitySameType(Sender $entity): bool;

    /**
     * @param ChannelType $channelType
     * @return bool
     */
    public function canUseChannelType(ChannelType $channelType): bool;
}
