<?php

declare(strict_types=1);

namespace Mailery\Sender\Repository;

use Cycle\ORM\Select\Repository;
use Mailery\Brand\Entity\Brand;
use Mailery\Sender\Filter\SenderFilter;
use Mailery\Sender\Model\Status;
use Yiisoft\Data\Paginator\PaginatorInterface;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Reader\DataReaderInterface;
use Mailery\Cycle\Mapper\Data\Reader\Inheritance;
use Mailery\Cycle\Mapper\Data\Reader\InheritanceDataReader;
use Cycle\ORM\Select;

class SenderRepository extends Repository
{
    /**
     * @param Inheritance $inheritance
     * @param Select $select
     */
    public function __construct(
        private Inheritance $inheritance,
        Select $select
    ) {
        parent::__construct($select);
    }

    /**
     * @param mixed $id
     * @return object|null
     */
    public function findByPK(mixed $id): ?object
    {
        return $this->inheritance->inherit(parent::findByPK($id));
    }

    /**
     * @param array $scope
     * @param array $orderBy
     * @return DataReaderInterface
     */
    public function getDataReader(array $scope = [], array $orderBy = []): DataReaderInterface
    {
        return new InheritanceDataReader(
            $this->inheritance,
            $this->select()->where($scope)->orderBy($orderBy)
        );
    }

    /**
     * @param SenderFilter $filter
     * @return PaginatorInterface
     */
    public function getFullPaginator(SenderFilter $filter): PaginatorInterface
    {
        $dataReader = $this->getDataReader();

        if (!$filter->isEmpty()) {
            $dataReader = $dataReader->withFilter($filter);
        }

        return new OffsetPaginator(
            $dataReader->withSort(
                Sort::only(['id'])->withOrder(['id' => 'DESC'])
            )
        );
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public function withBrand(Brand $brand): self
    {
        $repo = clone $this;
        $repo->select
            ->andWhere([
                'brand_id' => $brand->getId(),
            ]);

        return $repo;
    }

    /**
     * @param Status $status
     * @return self
     */
    public function withStatus(Status $status): self
    {
        $repo = clone $this;
        $repo->select
            ->andWhere([
                'status' => $status->getValue(),
            ]);

        return $repo;
    }
}
