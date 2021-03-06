<?php

declare(strict_types=1);

namespace Mailery\Sender\Repository;

use Cycle\ORM\Select\Repository;
use Yiisoft\Yii\Cycle\Data\Reader\EntityReader;
use Mailery\Brand\Entity\Brand;
use Mailery\Sender\Filter\SenderFilter;
use Mailery\Sender\Model\Status;
use Yiisoft\Data\Paginator\PaginatorInterface;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Reader\DataReaderInterface;

class SenderRepository extends Repository
{
    /**
     * @param array $scope
     * @param array $orderBy
     * @return DataReaderInterface
     */
    public function getDataReader(array $scope = [], array $orderBy = []): DataReaderInterface
    {
        return new EntityReader($this->select()->where($scope)->orderBy($orderBy));
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
