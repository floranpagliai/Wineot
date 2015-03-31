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
//        $this->dm = $this->getDocumentManager('WineotDataBundle:Wine');
//    }
//
//    /**
//     * @param Wine $wine
//     */
//    private function add(Wine $wine)
//    {
//        $this->dm->persist($wine);
//        $this->dm->flush();
//    }
//
//    /**
//     * @param Integer $id
//     */
//    private function delete($id)
//    {
////        $wine = $this->dm->find($id);
////
////        if ($wine) {
////            $this->dm->remove($wine);
////            $this->dm->flush();
////        }
//    }
}