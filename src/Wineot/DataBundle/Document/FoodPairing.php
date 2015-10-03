<?php
/**
 * User: floran
 * Date: 02/10/15
 * Time: 18:07
 */

namespace Wineot\DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="food_pairings")
 */
class FoodPairing
{
    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

}