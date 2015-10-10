<?php

namespace Wineot\DataBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Wineot\DataBundle\Document\Wine;
use Wineot\DataBundle\Document\Winery;

/**
 * WineRepository
 */
class WineRepository extends DocumentRepository
{

    /**
     * Find wines from a array of string terms or an array of wineries
     *
     * @param $search
     * @param $color
     * @param null $wineries
     * @return mixed
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function search($search, $color, $wineries = null) {
        $wineriesIds = array();
        foreach ($wineries as $winery)
            $wineriesIds[] = $winery->getId();

        //Find wines for the searched text or with the id of wineries found
        $query = $this->createQueryBuilder('WineotDataBundle:Wine');
        $query
            ->addOr($query->expr()->field('name')->in($search))
            ->addOr($query->expr()->field('winery')->in($wineriesIds))
            ->sort('name', 'ASC');

        if ($color != 3)
            $query->field('color')->equals(intval($color));
        $wines = $query->getQuery()->execute();
        return $wines;

    }

    public function findTrendingWines()
    {
        $query = $this->createQueryBuilder();
        $query->sort('name', 'ASC')
            ->limit(3);
        return $query->getQuery()->execute();
    }

    public function findBestRatedWines($wineryId)
    {
        $query = $this->createQueryBuilder();
        $query->field('winery')->equals($wineryId);
        $query->sort('avg_rating', 'DESC')
            ->limit(3);
        return $query->getQuery()->execute();
    }

    public function getCount()
    {
        return $this->createQueryBuilder()->getQuery()->execute()->count();
    }
}