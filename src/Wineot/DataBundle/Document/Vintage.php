<?php
/**
 * User: floran
 * Date: 30/03/15
 * Time: 16:59
 */

namespace Wineot\DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Wineot\DataBundle\Document\Comment;

/**
 * @MongoDB\Document(collection="vintages")
 */
class Vintage {
    /**
     * @var integer
     *
     * @MongoDB\Field(type="int", name="production_year")
     * @Assert\NotBlank()
     */
    private $productionYear;

    /**
     * @var array
     *
     * @MongoDB\Field(name="comments")
     * @MongoDB\ReferenceMany(targetDocument="Comment", mappedBy="vintageId", nullable=true)
     */
    private $comments;

    /**
     * @var integer
     *
     * @MongoDB\Field(name="wine_id")
     * @MongoDB\ReferenceOne(targetDocument="Wine", inversedBy="vintages")
     */
    private $wine;

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
        return $this->comments;
    }

    /**
     * Set wineId
     *
     * @param \Wineot\DataBundle\Document\Wine $wineId
     * @return self
     */
    public function setWine(\Wineot\DataBundle\Document\Wine $wineId)
    {
        $this->wine = $wineId;
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
}
