<?php
/**
 * User: floran
 * Date: 30/03/15
 * Time: 16:59
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\JsonSerializationVisitor;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;


/**
 * @MongoDB\Document(collection="vintages", repositoryClass="Wineot\DataBundle\Repository\VintageRepository")
 */

class Vintage
{
    /**
     * @var integer
     * @JMS\Type("integer")
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var Wine
     * @JMS\Type("Wine")
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Wine",
     *  cascade={"persist"},
     *  simple=true)
     */
    private $wine;

    /**
     * @var Int
     * @JMS\Type("integer")
     *
     * @MongoDB\Field(type="int", name="production_year"))
     * @Assert\NotBlank()
     */
    private $productionYear;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     *
     * @MongoDB\Field(type="boolean", name="is_bio")
     */
    private $isBio = false;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     *
     * @MongoDB\Field(type="boolean", name="contains_sulphites")
     */
    private $containsSulphites = false;

    /**
     * @var Int
     * @JMS\Type("integer")
     *
     * @MongoDB\Field(type="int", nullable=true))
     */
    private $keeping;

    /**
     * @var Int
     * @JMS\Type("integer")
     *
     * @MongoDB\Field(type="int", nullable=true))
     */
    private $peak;

    /**
     * @var float
     * @JMS\Type("float")
     *
     * @MongoDB\Field(type="float", nullable=true)
     */
    private $alcohol;

    /**
     * @var float
     * @JMS\Type("float")
     *
     * @MongoDB\Field(type="float", name="winery_price", nullable=true)
     */
    private $wineryPrice;

    /**
     * @var Image
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Image",
     *  cascade={"all"},
     *  simple=true)
     */
    private $labelPicture;

    /**
     * @var Image
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Image",
     *  cascade={"all"},
     *  simple=true)
     */
    private $bottlePicture;

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

    /**
     * @var TasteProfile
     *
     * @MongoDB\EmbedOne(targetDocument="TasteProfile")
     */
    private $tasteProfile;

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
     * @param Image $bottlePicture
     */
    public function setBottlePicture($bottlePicture)
    {
        $this->bottlePicture = $bottlePicture;
    }

    /**
     * @return Image
     */
    public function getBottlePicture()
    {
        return $this->bottlePicture;
    }

    /**
     * @return TasteProfile
     */
    public function getTasteProfile()
    {
        return $this->tasteProfile;
    }

    /**
     * @param TasteProfile $tasteProfile
     */
    public function setTasteProfile($tasteProfile)
    {
        $this->tasteProfile = $tasteProfile;
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
     * @return Winery
     */
    public function getWinery()
    {
        return $this->wine->getWinery();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->wine->getName();
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->wine->getDescription();
    }

    /**
     * @return int
     */
    public function getColor()
    {
        return $this->wine->getColor();
    }

    /**
     * @return Collection
     */
    public function getVintages()
    {
        return $this->wine->getVintages();
    }

    /**
     * @return Collection
     */
    public function getFoodPairings()
    {
        return $this->wine->getFoodPairings();
    }

    /**
     * @return Collection
     */
    public function getGrappes()
    {
        return $this->wine->getGrappes();
    }

    /**
     * @param Image $picture
     */
    public function removePicture(Image $picture)
    {
        if ($this->bottlePicture == $picture)
            $this->bottlePicture = null;
        elseif ($this->labelPicture == $picture)
            $this->labelPicture = null;
    }

    /**
     * Get one image of the wintage or the wintage
     * @return null|Image
     */
    public function getPicture()
    {
        if ($this->bottlePicture)
            return $this->bottlePicture;
        elseif ($this->wine->getBottlePicture())
            return $this->getWine()->getBottlePicture();
        elseif ($this->labelPicture)
            return $this->labelPicture;
        elseif ($this->getWine()->getLabelPicture())
            return $this->getWine()->getLabelPicture();
        else
            return null;
    }

    /**
     * @return null|string
     */
    public function getAvgRating()
    {
        $comments = $this->getComments();
        if ($comments->count() != 0) {
            $avgRating = 0;
            foreach($comments as $comment)
            {
                $avgRating += $comment->getRank();
            }
            return number_format($avgRating/$comments->count(), 2);
        } else
            return null;
    }

    /**
     * @return null|string
     */
    public function getAvgPrice()
    {
        //TODO : Calculate price based on sellings
        if ($this->wineryPrice > 0)
            return number_format($this->wineryPrice, 2, ".", " ");
        else
            return null;
    }

    /**
     * Get data for serialization of current object
     *
     * @return array
     */
    public function getDataArray()
    {
        $data = array();
        $data['id'] = $this->getId();
        $data['wine'] = $this->getWine()->getDataArray(false);
        $data['vintage'] = $this->getProductionYear();
        $data['is_bio'] = $this->isIsBio();
        $data['contains_sulphites'] = $this->isContainsSulphites();
        $data['peak'] = $this->getPeak();
        $data['keeping'] = $this->getKeeping();
        $data['avg_rating'] = $this->getAvgRating();
        $data['avg_price'] = $this->getAvgPrice();
        return $data;
    }

    /**
     * @JMS\HandlerCallback("json", direction = "serialization")
     * @param JsonSerializationVisitor $visitor
     */
    public function serializeToJson(JsonSerializationVisitor $visitor)
    {
        $visitor->setRoot($this->getDataArray());
    }
}
