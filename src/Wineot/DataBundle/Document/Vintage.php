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
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Wineot\DataBundle\Document\Comment;

/**
 * @MongoDB\Document(collection="vintages")
 * @MongoDBUnique(fields={"wine", "productionYear"}, message="wine.warn.unique_vintage")
 */

class Vintage
{
    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var Wine
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Wine",
     *  simple=true)
     */
    private $wine;

    /**
     * @var Int
     *
     * @MongoDB\Field(type="int", name="production_year"))
     * @Assert\NotBlank()
     */
    private $productionYear;

    /**
     * @var boolean
     *
     * @MongoDB\Field(type="boolean", name="is_bio")
     */
    private $isBio;

    /**
     * @var boolean
     *
     * @MongoDB\Field(type="boolean", name="contains_sulphites")
     */
    private $containsSulphites;

    /**
     * @var Int
     *
     * @MongoDB\Field(type="int", nullable=true))
     */
    private $keeping;

    /**
     * @var Int
     *
     * @MongoDB\Field(type="int", nullable=true))
     */
    private $peak;

    /**
     * @var float
     *
     * @MongoDB\Field(type="float", nullable=true)
     */
    private $alcohol;

    /**
     * @var float
     *
     * @MongoDB\Field(type="float", name="winery_price", nullable=true)
     */
    private $wineryPrice;

    /**
     * @var Image
     *
     * @MongoDB\Field(name="label_picture")
     * @MongoDB\ReferenceOne(
     *  targetDocument="Image",
     *  cascade={"persist"},
     *  simple=true)
     */
    private $labelPicture;

    /**
     * @var collection
     *
     * @MongoDB\ReferenceMany(
     *  targetDocument="Comment",
     *  mappedBy="wine",
     *  cascade={"all"},
     *  nullable=true)
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Wineot\DataBundle\Document\Wine $wine
     */
    public function setWine($wine)
    {
        $this->wine = $wine;
    }

    /**
     * @return \Wineot\DataBundle\Document\Wine
     */
    public function getWine()
    {
        return $this->wine;
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
     * @return boolean
     */
    public function isIsBio()
    {
        return $this->isBio;
    }

    /**
     * @param boolean $isBio
     */
    public function setIsBio($isBio)
    {
        $this->isBio = $isBio;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return boolean
     */
    public function isContainsSulphites()
    {
        return $this->containsSulphites;
    }

    /**
     * @param boolean $containsSulphites
     */
    public function setContainsSulphites($containsSulphites)
    {
        $this->containsSulphites = $containsSulphites;
    }

    /**
     * @return Int
     */
    public function getKeeping()
    {
        return $this->keeping;
    }

    /**
     * @param Int $keeping
     */
    public function setKeeping($keeping)
    {
        $this->keeping = $keeping;
    }

    /**
     * @return Int
     */
    public function getPeak()
    {
        return $this->peak;
    }

    /**
     * @param Int $peak
     */
    public function setPeak($peak)
    {
        $this->peak = $peak;
    }

    /**
     * @return float
     */
    public function getAlcohol()
    {
        return $this->alcohol;
    }

    /**
     * @param float $alcohol
     */
    public function setAlcohol($alcohol)
    {
        $this->alcohol = $alcohol;
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

    /**
     * @param \Wineot\DataBundle\Document\Image $labelPicture
     */
    public function setLabelPicture($labelPicture)
    {
        $this->labelPicture = $labelPicture;
    }

    /**
     * @return \Wineot\DataBundle\Document\Image
     */
    public function getLabelPicture()
    {
        return $this->labelPicture;
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

    public function getWinery()
    {
        return $this->wine->getWinery();
    }

    public function getName()
    {
        return $this->wine->getName();
    }

    public function getDescription()
    {
        return $this->wine->getDescription();
    }

    public function getColor()
    {
        return $this->wine->getColor();
    }

    public function getVintages()
    {
        return $this->wine->getVintages();
    }

    public function getFoodPairings()
    {
        return $this->wine->getFoodPairings();
    }

    public function getGrappes()
    {
        return $this->wine->getGrappes();
    }

    public function getAvgRating()
    {
        $comments = $this->getComments();
        if ($comments->count() != 0) {
            $avgRating = 0;
            foreach($comments as $comment)
            {
                $avgRating += $comment->getRank();
            }
            return number_format($avgRating/$comments->count(), 1);
        } else
            return null;
    }

    public function getAvgPrice()
    {
        //TODO : Calculate price based on sellings
        return number_format($this->wineryPrice, 2, ",", " ");
    }
}
