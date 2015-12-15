<?php
/**
 * User: floran
 * Date: 05/09/15
 * Time: 22:44
 */

namespace Wineot\DataBundle\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Wineot\DataBundle\Document\Wine;
use Wineot\DataBundle\Document\Winery;

class WineryRepository extends DocumentRepository {


    /**
     * Find wineries from a array of string terms
     *
     * @param $search
     * @return mixed
     */
    public function search($search) {
        $query = $this->createQueryBuilder();
        $wineries = $query
            ->field('name')->in($search)
            ->getQuery()->execute();

        return $wineries;
    }

    /**
     * Get the count of wineries present in database
     *
     * @return mixed
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getCount()
    {
        return $this->createQueryBuilder()->getQuery()->execute()->count();
    }

    /**
     * Maintenance function who init the wines collection of all winery
     * Need to call WineRepository->ensureWineryRelation() after
     */
    public function ensureWineRelation()
    {
        $dm = $this->getDocumentManager();

        $wineries = $this->findAll();

        foreach ($wineries as $winery)
        {
            /** @var Winery $winery */
            $winery->setWines(new ArrayCollection());
            $dm->persist($winery);
        }
        $dm->flush();
    }
} 