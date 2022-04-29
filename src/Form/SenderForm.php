<?php

declare(strict_types=1);

namespace Mailery\Sender\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\InRange;
use Mailery\Channel\Repository\ChannelRepository;
use Mailery\Brand\BrandLocatorInterface as BrandLocator;
use Mailery\Channel\Entity\Channel;

class SenderForm extends FormModel
{
    /**
     * @var string|null
     */
    private ?int $channel = null;

    /**
     * @param ChannelRepository $channelRepo
     * @param BrandLocator $brandLocator
     */
    public function __construct(
        private ChannelRepository $channelRepo,
        BrandLocator $brandLocator
    ) {
        $this->channelRepo = $channelRepo->withBrand($brandLocator->getBrand());
        parent::__construct();
    }

    /**
     * @return Channel|null
     */
    public function getChannel(): ?Channel
    {
        if ($this->channel === null) {
            return null;
        }

        return $this->channelRepo->findByPK($this->channel);
    }

    /**
     * @return array
     */
    public function getAttributeLabels(): array
    {
        return [
            'channel' => 'Channel',
        ];
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'channel' => [
                Required::rule(),
                InRange::rule(array_keys($this->getChannelListOptions())),
            ],
        ];
    }

    /**
     * @return array
     */
    public function getChannelListOptions(): array
    {
        $options = [];
        $channels = $this->channelRepo->findAll();

        foreach ($channels as $channel) {
            $options[$channel->getId()] = $channel->getName();
        }

        return $options;
    }

}
