<?php
/**
 * User: floran
 * Date: 05/09/15
 * Time: 22:44
 */

namespace Wineot\DataBundle\Repository;


use Doctrine\ODM\MongoDB\DocumentRepository;

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
} 