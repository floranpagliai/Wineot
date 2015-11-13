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

class WineryRepository extends DocumentRepository {


    /**
     * Find wineries from a array of string terms
     *
     * @param $search
     * @return mixed
     */
    public function search($search) {
        $query = $this->createQueryBuilder('WineotDataBundle:Winery');
        $wineries = $query
            ->field('name')->in($search)
            ->getQuery()->execute();

        return $wineries;
    }

    public function getCount()
    {
        return $this->createQueryBuilder()->getQuery()->execute()->count();
    }

    public function ensureWineRelation()
    {
        $dm = $this->getDocumentManager();

        $wineries = $this->findAll();
        foreach ($wineries as $winery)
        {
            $winery->setWines(new ArrayCollection());
            $dm->persist($winery);
        }
        $dm->flush();
    }
} 