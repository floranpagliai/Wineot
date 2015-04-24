<?php
/**
 * User: floran
 * Date: 30/03/15
 * Time: 16:59
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
use Symfony\Component\Validator\Constraints as Assert;
use Wineot\DataBundle\Document\Comment;

/**
 * @MongoDB\EmbeddedDocument
 */
class Vintage
{
    /**
     * @var Int
     *
     * @MongoDB\Field(type="int", name="production_year")
     * @Assert\NotBlank()
     */
    private $productionYear;

    /**
     * @var float
     *
     * @MongoDB\Field(type="float", name="winery_price", nullable=true)
     */
    private $wineryPrice;

    /**
     * @var collection
     *
     * @MongoDB\Field(name="comments")
     * @MongoDB\ReferenceMany(targetDocument="Comment", mappedBy="vintage", nullable=true)
     */
    private $comments;

//    /**
//     * @var integer
//     *
//     * @MongoDB\Field(name="wine_id")
//     * @MongoDB\ReferenceOne(targetDocument="Wine", inversedBy="vintages", simple=true)
//     */
//    private $wine;
//
//    /**
//     * @var integer
//     *
//     * @MongoDB\Id
//     */
//    private $id;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * Set productionYear
     *
     * @param int $productionYear
     * @return self
     */
    public function setProductionYear($productionYear)
    {
        $this->productionYear = $productionYear;
        return $this;
    }

    /**
     * Get productionYear
     *
     * @return int $productionYear
     */
    public function getProductionYear()
    {
        return $this->productionYear;
    }

    /**
     * Add comment
     *
     * @param \Wineot\DataBundle\Document\Comment $comment
     */
    public function addComment(\Wineot\DataBundle\Document\Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Remove comment
     *
     * @param \Wineot\DataBundle\Document\Comment $comment
     */
    public function removeComment(\Wineot\DataBundle\Document\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection $comments
     */
    public function getComments()
    {
        if (!empty($this->comments))
            return $this->comments;
        else
            return NULL;
    }

    /**
     * Set wineId
     *
     * @param \Wineot\DataBundle\Document\Wine $wine
     * @return self
     */
    public function setWine(Wine $wine)
    {
        $this->wine = $wine;
        return $this;
    }

    /**
     * Get wineId
     *
     * @return \Wineot\DataBundle\Document\Wine $wineId
     */
    public function getWine()
    {
        return $this->wine;
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set wineryPrice
     *
     * @param float $wineryPrice
     * @return self
     */
    public function setWineryPrice($wineryPrice)
    {
        $this->wineryPrice = $wineryPrice;
        return $this;
    }

    /**
     * Get wineryPrice
     *
     * @return float $wineryPrice
     */
    public function getWineryPrice()
    {
        return $this->wineryPrice;
    }
}
