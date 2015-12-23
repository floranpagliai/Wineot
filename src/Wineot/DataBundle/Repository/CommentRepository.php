<?php
/**
 * Created by PhpStorm.
 * User: flpag
 * Date: 23/12/15
 * Time: 14:35
 */

namespace Wineot\DataBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class CommentRepository extends DocumentRepository
{
    /**
     * Get the count of comments present in database
     *
     * @return mixed
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getCount()
    {
        return $this->createQueryBuilder()->getQuery()->execute()->count();
    }
}