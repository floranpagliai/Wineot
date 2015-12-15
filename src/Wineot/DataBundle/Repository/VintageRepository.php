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

    /**
     * Get the newest vintage for a wine
     *
     * @param Wine $id
     * @return array|null|object
     */
    public function getNewest($id)
    {
        return $this->createQueryBuilder()
            ->field('wine')->equals($id)
            ->sort('production_year', 'DESC')
            ->getQuery()->getSingleResult();
    }

    /**
     * Get the count of vintages present in database
     *
     * @return mixed
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getCount()
    {
        return $this->createQueryBuilder()->getQuery()->execute()->count();
    }
}