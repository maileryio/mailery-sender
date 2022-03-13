<?php

namespace Mailery\Sender\Model;

use InvalidArgumentException;
use Mailery\Sender\Entity\Sender;
use Yiisoft\Translator\TranslatorInterface;

class Status
{
    public const PENDING = 'pending';
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';

    /**
     * @var TranslatorInterface|null
     */
    private ?TranslatorInterface $translator = null;

    /**
     * @param string $value
     */
    public function __construct(
        private string $value
    ) {
        if (!isset($this->getLabels()[$value])) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
    }

    /**
     * @param TranslatorInterface $translator
     * @return self
     */
    public function withTranslator(TranslatorInterface $translator): self
    {
        $new = clone $this;
        $new->translator = $translator;

        return $new;
    }

    /**
     * @return self
     */
    public static function asPending(): self
    {
        return new self(self::PENDING);
    }

    /**
     * @return self
     */
    public static function asActive(): self
    {
        return new self(self::ACTIVE);
    }

    /**
     * @return self
     */
    public static function asInactive(): self
    {
        return new self(self::INACTIVE);
    }

    /**
     * @param Sender $entity
     * @return self
     */
    public static function fromEntity(Sender $entity): self
    {
        return new self($entity->getStatus());
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getLabels()[$this->value] ?? '';
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return [
            self::PENDING => $this->translate('Pending'),
            self::ACTIVE => $this->translate('Active'),
            self::INACTIVE => $this->translate('Inactive'),
        ];
    }

    /**
     * @param string $message
     * @return string
     */
    private function translate(string $message): string
    {
        if ($this->translator !== null) {
            return $this->translator->translate($message);
        }
        return $message;
    }
}
