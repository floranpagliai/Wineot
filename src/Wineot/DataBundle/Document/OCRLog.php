<?php
/**
 * User: floran
 * Date: 17/11/2015
 * Time: 20:13
 */

namespace Wineot\DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="ocrlogs")
 *
 */
class OCRLog
{

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var Image
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Image",
     *  cascade={"all"},
     *  simple=true)
     */
    private $image;
}