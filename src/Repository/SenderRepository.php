<?php

declare(strict_types=1);

namespace Mailery\Sender\Repository;

use Cycle\ORM\Select\Repository;
use Mailery\Brand\Entity\Brand;
use Mailery\Sender\Entity\Sender;
use Mailery\Sender\Filter\SenderFilter;
use Mailery\Sender\Field\SenderStatus;
use Yiisoft\Data\Paginator\PaginatorInterface;
use Yiisoft\Data\Paginator\OffsetPaginator;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Reader\DataReaderInterface;
use Cycle\ORM\Select\QueryBuilder;
use Yiisoft\Yii\Cycle\Data\Reader\EntityReader;

class SenderRepository extends Repository
{
    /**
     * @param string $attribute
     * @param string $value
     * @param Sender|null $exclude
     * @return Sender|null
     */
    public function findByAttribute(string $attribute, string $value, ?Sender $exclude = null): ?Sender
    {
        return $this
            ->select()
            ->where(function (QueryBuilder $select) use ($attribute, $value, $exclude) {
                $select->where($attribute, $value);

                if ($exclude !== null) {
                    $select->where('id', '<>', $exclude->getId());
                }
            })
            ->fetchOne();
    }

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
                Sort::only(['id'])->withOrder(['id' => 'desc'])
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
     * @return self
     */
    public function withActive(): self
    {
        $repo = clone $this;
        $repo->select
            ->andWhere([
                'status' => SenderStatus::asActive()->getValue(),
            ]);

        return $repo;
    }

    /**
     * @param Sender $sender
     * @return self
     */
    public function withSameType(Sender $sender): self
    {
        $repo = clone $this;
        $repo->select
            ->andWhere([
                'type' => $sender->getType(),
            ]);

        return $repo;
    }
}
