<?php

namespace Wineot\DataBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
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

        return $this->createQueryBuilder()
            ->sort('name', 'ASC')
            ->limit(3)
            ->getQuery()->execute();
    }

    public function findBestRatedWines($wineryId = null)
    {
        $query = $this->createQueryBuilder();
        if ($wineryId)
            $query->field('winery')->equals($wineryId);

        return $query->sort('avg_rating', 'ASC')
                ->limit(3)
                ->getQuery()->execute();
    }

    public function getCount()
    {
        return $this->createQueryBuilder()->getQuery()->execute()->count();
    }

    public function ensureVintagesRelation()
    {
        $dm = $this->getDocumentManager();

        $wines = $this->findAll();
        foreach ($wines as $wine)
        {
            foreach ($wine->getVintages() as $vintage)
            {
                $vintage->setWine($wine);
            }
            $dm->persist($wine);
        }
        $dm->flush();
    }

    public function ensureWineryRelation()
    {
        $dm = $this->getDocumentManager();

        $wines = $this->findAll();
        foreach ($wines as $wine)
        {
            $winery = $wine->getWinery();
            $winery->addWine($wine);
            $dm->persist($winery);
        }
        $dm->flush();
    }

    public function unverifyAll()
    {
        $dm = $this->getDocumentManager();

        $wines = $this->findAll();
        foreach ($wines as $wine)
        {
            $wine->setIsVerified(false);
            $dm->persist($wine);
        }
        $dm->flush();
    }
}