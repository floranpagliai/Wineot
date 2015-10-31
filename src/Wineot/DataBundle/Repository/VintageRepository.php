<?php
/**
 * User: floran
 * Date: 05/09/15
 * Time: 22:44
 */

namespace Wineot\DataBundle\Repository;


use Doctrine\ODM\MongoDB\DocumentRepository;
use Wineot\DataBundle\Document\Wine;

class VintageRepository extends DocumentRepository
{

    public function getAll()
    {
        return $this->createQueryBuilder()->getQuery()->execute();
    }

    public function getNewest($wineId)
    {
        return $this->createQueryBuilder()
            ->field('wine')->equals($wineId)
            ->sort('production_year', 'DESC')
            ->getQuery()->getSingleResult();
    }

    public function getCount()
    {
        return $this->createQueryBuilder()->getQuery()->execute()->count();
    }
}