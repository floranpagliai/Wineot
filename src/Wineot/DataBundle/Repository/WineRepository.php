<?php

namespace Wineot\DataBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Wineot\DataBundle\Document\Vintage;
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
        /** @var Winery $winery */
        foreach ($wineries as $winery)
            $wineriesIds[] = $winery->getId();

        //Find wines for the searched text or with the id of wineries found
        $query = $this->createQueryBuilder();
        $query
            ->addOr($query->expr()->field('name')->in($search))
            ->addOr($query->expr()->field('winery')->in($wineriesIds))
            ->sort('name', 'ASC');

        if ($color != 3)
            $query->field('color')->equals(intval($color));
        $wines = $query->getQuery()->execute();
        return $wines;

    }

    /**
     * Find 3 most viewed wines in a month
     *
     * @return mixed
     */
    public function findTrendingWines()
    {

        return $this->createQueryBuilder()
            ->sort('name', 'ASC')
            ->limit(3)
            ->getQuery()->execute();
    }

    /**
     * Find 3 best rated wines off all times
     *
     * @param null $wineryId
     * @return mixed
     */
    public function findBestRatedWines($wineryId = null)
    {
        $query = $this->createQueryBuilder();
        if ($wineryId)
            $query->field('winery')->equals($wineryId);

        return $query->sort('avg_rating', 'DESC')
                ->limit(3)
                ->getQuery()->execute();
    }

    /**
     * Get the count of wines present in database
     *
     * @return mixed
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getCount()
    {
        return $this->createQueryBuilder()->getQuery()->execute()->count();
    }

    /**
     * Calculate average rating for a wine and persist it
     *
     * @param Wine $id
     * @throws \Doctrine\ODM\MongoDB\LockException
     */
    public function calculateAvgRating($id)
    {
        $dm = $this->getDocumentManager();

        $wine = $this->find($id);
        if ($wine->getVintages()->count() != 0) {
            $avgRating = 0;
            $ratedVintageCount = 0;
            $vintages = $wine->getVintages();
            /** @var Vintage $vintage */
            foreach($vintages as $vintage)
            {
                if ($vintage->getAvgRating())
                    $ratedVintageCount++;
                $avgRating += $vintage->getAvgRating();
            }
            if ($ratedVintageCount != 0)
                $wine->setAvgRating($avgRating/$ratedVintageCount);
            $dm->persist($wine);
            $dm->flush();
        }
    }

    /**
     * Maintenance function who set the id of parent wine to each vintages
     */
    public function ensureVintagesRelation()
    {
        $dm = $this->getDocumentManager();

        $wines = $this->findAll();
        /** @var Wine $wine */
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

    /**
     * Maintenance function who set the id of parent winery to each wines
     */
    public function ensureWineryRelation()
    {
        $dm = $this->getDocumentManager();

        $wines = $this->findAll();
        /** @var Wine $wine */
        foreach ($wines as $wine)
        {
            $winery = $wine->getWinery();
            $winery->addWine($wine);
            $dm->persist($winery);
        }
        $dm->flush();
    }

    /**
     * Maintenance function who set isVerified on false for each wines
     */
    public function unverifyAll()
    {
        $dm = $this->getDocumentManager();

        $wines = $this->findAll();
        /** @var Wine $wine */
        foreach ($wines as $wine)
        {
            $wine->setIsVerified(false);
            $dm->persist($wine);
        }
        $dm->flush();
    }

    /**
     * Maintenance function who calculate average rating for each wines
     */
    public function ensureAvgRating()
    {
        $wines = $this->findAll();
        /** @var Wine $wine */
        foreach ($wines as $wine)
            $this->calculateAvgRating($wine->getId());
    }
}