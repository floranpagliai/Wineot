<?php
/**
 * User: floran
 * Date: 26/03/15
 * Time: 00:09
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Wineot\DataBundle\Document\Comment;

/**
 * @MongoDB\Document(collection="wines", repositoryClass="Wineot\DataBundle\Repository\WineRepository")
 */
class Wine
{
    const COLOR_RED = 0;
    const COLOR_PINK = 1;
    const COLOR_WHITE = 2;

    const FOOD_TYPE_MEET = 0;
    const FOOD_TYPE_FISH = 1;
    const FOOD_TYPE_VEGETABLE = 2;
    const FOOD_TYPE_CHEESE = 3;
    const FOOD_TYPE_DESERT = 4;

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var Winery
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Winery",
     *  inversedBy="wines",
     *  simple=true)
     */
    private $winery;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      max = 255
     * )
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    private $description;

    /**
     * @var integer
     *
     * @MongoDB\Field(type="int")
     * @Assert\NotBlank()
     */
    private $color;

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
     *  targetDocument="Vintage",
     *  cascade={"all"},
     *  simple=true)
     */
    private $vintages;

    /**
     * @var collection
     *
     * @MongoDB\ReferenceMany(
     *  targetDocument="WineGrappe",
     *  cascade={"all"},
     *  simple=true)
     */
    private $grappes;

    /**
     * @var collection
     *
     * @MongoDB\Field(type="collection", name="food_pairings", nullable=true)
     */
    private $foodPairings;


    public function __construct()
    {
        $this->foodPairings = Array();
        $this->vintages = new ArrayCollection();
        $this->grappes = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set color
     *
     * @param int $color
     * @return self
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * Get color
     *
     * @return int $color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Add vintage
     *
     * @param \Wineot\DataBundle\Document\Vintage $vintage
     */
    public function addVintage(Vintage $vintage)
    {
        $this->vintages[] = $vintage;
        $vintage->setWine($this);
    }

    /**
     * Remove vintage
     *
     * @param \Wineot\DataBundle\Document\Vintage $vintage
     */
    public function removeVintage(Vintage $vintage)
    {
        $this->vintages->removeElement($vintage);
        $vintage->setWine(null);
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $vintages
     * @return $this
     */
    public function setVintages($vintages)
    {
        $this->vintages = $vintages;
        return $this;
    }

    /**
     * Get vintages
     *
     * @return \Doctrine\Common\Collections\Collection $vintages
     */
    public function getVintages()
    {
        return $this->vintages;
    }

    /**
     * @param Collection $foodPairings
     * @return self
     */
    public function setFoodPairings($foodPairings)
    {
        $this->foodPairings = $foodPairings;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getFoodPairings()
    {
//        var_dump($this->foodPairings->getValues());
        return $this->foodPairings;
    }

    /**
     * Set wineryId
     *
     * @param \Wineot\DataBundle\Document\Winery $wineryId
     * @return self
     */
    public function setWinery(Winery $wineryId)
    {
        $this->winery = $wineryId;
        return $this;
    }

    /**
     * Get winery
     *
     * @return \Wineot\DataBundle\Document\Winery $winery
     */
    public function getWinery()
    {
        return $this->winery;
    }

    public function getComments()
    {
        $comments = new ArrayCollection();
        foreach ($this->vintages as $vintage) {
            foreach ($vintage->getComments() as $comment)
                $comments->add($comment);
        }
        return $comments;
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


    public function isFavorited(User $user)
    {
        return $user->isFavorited($this);
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $grappes
     * @return self
     */
    public function setGrappes($grappes)
    {
        $this->grappes = $grappes;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrappes()
    {
        return $this->grappes;
    }

    /**
     * Add grappe
     *
     * @param \Wineot\DataBundle\Document\Grappe|\Wineot\DataBundle\Document\WineGrappe $grappe
     */
    public function addGrappe(\Wineot\DataBundle\Document\WineGrappe $grappe)
    {
        $this->grappes[] = $grappe;
    }

    /**
     * Remove grappe
     *
     * @param \Wineot\DataBundle\Document\Grappe|\Wineot\DataBundle\Document\WineGrappe $grappe
     */
    public function removeGrappe(\Wineot\DataBundle\Document\WineGrappe $grappe)
    {
        $this->grappes->removeElement($grappe);
        $grappe = null;
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
     * Get average rating for all comment of the wine
     * @return null|string
     */
    public function getAvgRating()
    {
        if ($this->vintages->count() != 0) {
            $avgRating = 0;
            $ratedVintageCount = 0;
            $vintages = $this->vintages;
            foreach($vintages as $vintage)
            {
                if ($vintage->getAvgRating())
                    $ratedVintageCount++;
                $avgRating += $vintage->getAvgRating();
            }
            if ($ratedVintageCount != 0)
                return number_format($avgRating/$ratedVintageCount, 1);
        }
        return null;
    }

    /**
     * Get average price for all vintages of the wine
     *
     * @return null|string
     */
    public function getAvgPrice()
    {
        if ($this->vintages->count() != 0) {
            $avgPrice = 0;
            $vintages = $this->vintages;
            foreach($vintages as $vintage)
            {
                $avgPrice += $vintage->getAvgPrice();
            }
            return number_format($avgPrice/$this->vintages->count(), 2, ",", " ");
        } else
            return null;
    }

    /**
     * @return array
     */
    public static function getColors()
    {
        return array(
            Wine::COLOR_RED => 'global.wine.color.red',
            Wine::COLOR_PINK => 'global.wine.color.pink',
            Wine::COLOR_WHITE => 'global.wine.color.white'
        );
    }

    /**
     * @return array
     */
    public static function getFoodTypes()
    {
        return array(
            Wine::FOOD_TYPE_MEET => 'global.wine.food_type.meet',
            Wine::FOOD_TYPE_FISH => 'global.wine.food_type.fish',
            Wine::FOOD_TYPE_VEGETABLE => 'global.wine.food_type.vegetable',
            Wine::FOOD_TYPE_CHEESE => 'global.wine.food_type.cheese',
            Wine::FOOD_TYPE_DESERT => 'global.wine.food_type.desert'
        );
    }
}
