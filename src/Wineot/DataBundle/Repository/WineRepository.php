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
//    /**
//     * @var DocumentManager $dm
//     */
//    protected  $dm;
//
//    public function __construct()
//    {
////        $this->dm = $this->getDocumentManager('WineotDataBundle:Wine');
//    }

    public function findTrendingWines()
    {
        $query = $this->createQueryBuilder('Wine');
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
}