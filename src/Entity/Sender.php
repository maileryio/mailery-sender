<?php

declare(strict_types=1);

namespace Mailery\Sender\Entity;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use Mailery\Brand\Entity\Brand;
use Mailery\Sender\Repository\SenderRepository;
use Mailery\Activity\Log\Mapper\LoggableMapper;
use Mailery\Sender\Field\SenderStatus;
use Cycle\ORM\Entity\Behavior;
use Cycle\Annotated\Annotation\Inheritance\DiscriminatorColumn;

#[Entity(
    table: 'senders',
    repository: SenderRepository::class,
    mapper: LoggableMapper::class
)]
#[Behavior\CreatedAt(
    field: 'createdAt',
    column: 'created_at',
)]
#[Behavior\UpdatedAt(
    field: 'updatedAt',
    column: 'updated_at',
)]
#[DiscriminatorColumn(name: 'type')]
abstract class Sender
{
    #[Column(type: 'primary')]
    protected int $id;

    #[BelongsTo(target: Brand::class)]
    protected Brand $brand;

    #[Column(type: 'string(255)')]
    protected string $name;

    #[Column(type: 'enum(pending, active, inactive)', typecast: SenderStatus::class)]
    protected SenderStatus $status;

    #[Column(type: 'string(255)')]
    protected string $type;

    #[Column(type: 'datetime')]
    protected \DateTimeImmutable $createdAt;

    #[Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeImmutable $updatedAt = null;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return SenderStatus
     */
    public function getStatus(): SenderStatus
    {
        return $this->status;
    }

    /**
     * @param SenderStatus $status
     * @return self
     */
    public function setStatus(SenderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }
}
