<?php

declare(strict_types=1);

namespace Mailery\Sender\Entity;

use RuntimeException;
use Mailery\Brand\Entity\Brand;
use Mailery\Common\Entity\RoutableEntityInterface;
use Mailery\Sender\Model\Status;

/**
 * @Cycle\Annotated\Annotation\Entity(
 *      table = "senders",
 *      repository = "Mailery\Sender\Repository\SenderRepository",
 *      mapper = "Mailery\Sender\Mapper\DefaultMapper"
 * )
 */
abstract class Sender implements RoutableEntityInterface
{
    /**
     * @Cycle\Annotated\Annotation\Column(type = "primary")
     * @var int|null
     */
    protected $id;

    /**
     * @Cycle\Annotated\Annotation\Relation\BelongsTo(target = "Mailery\Brand\Entity\Brand", nullable = false)
     * @var Brand
     */
    protected $brand;

    /**
     * @Cycle\Annotated\Annotation\Column(type = "string(255)")
     * @var string
     */
    protected $name;

    /**
     * @Cycle\Annotated\Annotation\Column(type = "enum(pending, active, inactive)")
     * @var string
     */
    protected $status;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id ? (string) $this->id : null;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return self
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->getStatus() === Status::PENDING;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getStatus() === Status::ACTIVE;
    }

    /**
     * @return bool
     */
    public function isInactive(): bool
    {
        return $this->getStatus() === Status::INACTIVE;
    }

    /**
     * {@inheritdoc}
     */
    public function getEditRouteName(): ?string
    {
        throw new RuntimeException('Must be implemented in nested.');
    }

    /**
     * {@inheritdoc}
     */
    public function getEditRouteParams(): array
    {
        throw new RuntimeException('Must be implemented in nested.');
    }

    /**
     * {@inheritdoc}
     */
    public function getViewRouteName(): ?string
    {
        throw new RuntimeException('Must be implemented in nested.');
    }

    /**
     * {@inheritdoc}
     */
    public function getViewRouteParams(): array
    {
        throw new RuntimeException('Must be implemented in nested.');
    }

    /**
     * {@inheritdoc}
     */
    public function getDeleteRouteName(): ?string
    {
        return '/sender/default/delete';
    }

    /**
     * {@inheritdoc}
     */
    public function getDeleteRouteParams(): array
    {
        return ['id' => $this->getId()];
    }
}
