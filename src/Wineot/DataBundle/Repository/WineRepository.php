<?php

namespace Wineot\DataBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Wineot\DataBundle\Document\Wine;

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

    public function findTrendingWines($winery)
    {
        $query = $this->createQueryBuilder()
            ->sort('name', 'ASC')
            ->limit(3);
        if ($winery)
            $query->field('winery')->equals($winery->getId());
        return $query->getQuery()->execute();
    }
}