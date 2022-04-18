<?php

namespace Mailery\Sender\Model;

interface SenderTypeInterface
{
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
     * @param object $entity
     * @return bool
     */
    public function isEntitySameType(object $entity): bool;
}
