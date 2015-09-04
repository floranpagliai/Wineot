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
use Symfony\Component\Validator\Constraints as Assert;
use Wineot\DataBundle\Document\Comment;

/**
 * @MongoDB\Document(collection="vintages")
 * @MongoDBUnique("wine")
 * @MongoDBUnique("productionYear")
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
     *  mappedBy="vintages",
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
}
