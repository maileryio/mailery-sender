<?php

declare(strict_types=1);

namespace Mailery\Sender\Mapper;

use Mailery\Activity\Log\Mapper\LoggableMapper;
use Mailery\Sender\Module;

/**
 * @Cycle\Annotated\Annotation\Table(
 *      columns = {
 *          "created_at": @Cycle\Annotated\Annotation\Column(type = "datetime"),
 *          "updated_at": @Cycle\Annotated\Annotation\Column(type = "datetime"),
 *          "_type": @Cycle\Annotated\Annotation\Column(type = "string(255)")
 *      }
 * )
 */
final class DefaultMapper extends LoggableMapper
{
    /**
     * {@inheritdoc}
     */
    protected function getModule(): string
    {
        return Module::NAME;
    }
}
