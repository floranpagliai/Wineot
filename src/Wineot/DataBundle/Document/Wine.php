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
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\HandlerCallback;

/**
 * @MongoDB\Document(collection="wines", repositoryClass="Wineot\DataBundle\Repository\WineRepository")
 *
 * @ExclusionPolicy("all")
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
     * @Expose
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @var Winery
     * @MaxDepth(2)
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Winery",
     *  cascade={"persist"},
     *  simple=true)
     */
    private $winery;

    /**
     * @var string
     * @Expose
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
     * @Expose
     *
     * @MongoDB\Field(type="string")
     */
    private $description;

    /**
     * @var integer
     * @Expose
     *
     * @MongoDB\Field(type="int")
     * @Assert\NotBlank()
     */
    private $color;

    /**
     * @var boolean
     * @Expose
     *
     * @MongoDB\Field(type="boolean", name="is_bio")
     */
    private $isBio;

    /**
     * @var boolean
     * @Expose
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
     * @Expose
     *
     * @MongoDB\ReferenceMany(
     *  targetDocument="Vintage",
     *  cascade={"all"},
     *  simple=true),
     *  sort={"productionYear": "ASC"}
     * @Assert\Valid
     */
    private $vintages;

    /**
     * @var collection
     * @Expose
     * @MaxDepth(2)
     *
     * @MongoDB\ReferenceMany(
     *  targetDocument="WineGrappe",
     *  cascade={"all"},
     *  simple=true)
     */
    private $grappes;

    /**
     * @var collection
     * @Expose
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
     * GETTER / SETTER
     */

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
     * @return int $color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set vintage
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
        return $this->foodPairings;
    }

    /**
     * Set winery
     *
     * @param \Wineot\DataBundle\Document\Winery $winery
     * @return self
     */
    public function setWinery(Winery $winery)
    {
        $this->winery = $winery;
        $this->winery->addWine($this);
        return $this;
    }

    /**
     * Get winery
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
     * ADDER / REMOVER
     */

    /**
     * Add vintage
     * @param \Wineot\DataBundle\Document\Vintage $vintage
     */
    public function addVintage(Vintage $vintage)
    {
        $this->vintages[] = $vintage;
        $vintage->setWine($this);
    }

    /**
     * Remove vintage
     * @param \Wineot\DataBundle\Document\Vintage $vintage
     */
    public function removeVintage(Vintage $vintage)
    {
        $this->vintages->removeElement($vintage);
        $vintage->setWine(null);
    }

    /**
     * Add grappe
     * @param \Wineot\DataBundle\Document\Grappe|\Wineot\DataBundle\Document\WineGrappe $grappe
     */
    public function addGrappe(\Wineot\DataBundle\Document\WineGrappe $grappe)
    {
        $this->grappes[] = $grappe;
    }

    /**
     * Remove grappe
     * @param \Wineot\DataBundle\Document\Grappe|\Wineot\DataBundle\Document\WineGrappe $grappe
     */
    public function removeGrappe(\Wineot\DataBundle\Document\WineGrappe $grappe)
    {
        $this->grappes->removeElement($grappe);
        $grappe = null;
    }

    /**
     * FUNCTIONS
     */

    /**
     * Set correct picture relation to null
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
     * @return null|string
     */
    public function getAvgPrice()
    {
        $avgPrice = 0;
        $count = 0;
        $vintages = $this->vintages;
        foreach($vintages as $vintage)
        {
            if ($vintage->getAvgPrice()) {
                $avgPrice += $vintage->getAvgPrice();
                $count++;
            }

        }
        if ($count != 0)
            return number_format($avgPrice/$count, 2, ",", " ");
        return null;
    }

    /**
     * Get color choices for a wine
     * @return array
     */
    public static function getColors()
    {
        return array(
            Wine::COLOR_RED => 'wine.title.color_red',
            Wine::COLOR_PINK => 'wine.title.color_pink',
            Wine::COLOR_WHITE => 'wine.title.color_white'
        );
    }

    /**
     * Get food type choice for a wine
     * @return array
     */
    public static function getFoodTypes()
    {
        return array(
            Wine::FOOD_TYPE_MEET => 'wine.title.food_type_meet',
            Wine::FOOD_TYPE_FISH => 'wine.title.food_type_fish',
            Wine::FOOD_TYPE_VEGETABLE => 'wine.title.food_type_vegetable',
            Wine::FOOD_TYPE_CHEESE => 'wine.title.food_type_cheese',
            Wine::FOOD_TYPE_DESERT => 'wine.title.food_type_desert'
        );
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->vintages->count() == 0) {
            $context->buildViolation('wine.warn.need_vintage')
                ->atPath('vintages')
                ->addViolation();

        } else {
            $vintagesProductionYear = null;
            foreach ($this->vintages as $vintage) {
                $vintagesProductionYear[] += $vintage->getProductionYear();
            }
            if (!count(array_unique($vintagesProductionYear)) == count($vintagesProductionYear))
                $context->buildViolation('crud.warn.wine.unique_vintage')
                    ->atPath('vintages')
                    ->addViolation();
        }
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
        $data['winery'] = $this->getWinery()->getDataArray();
        $data['name'] = $this->getName();
        $data['color'] = $this->getColor();
        $data['description'] = $this->getDescription();

        $vintages = array();
        foreach($this->getVintages() as $vintage)
            $vintages[] = $vintage->getDataArray();
        $data['vintages'] = $vintages;

        return $data;
    }

    /** @HandlerCallback("json", direction = "serialization")
     * @param JsonSerializationVisitor $visitor
     */
    public function serializeToJson(JsonSerializationVisitor $visitor)
    {
        $visitor->setRoot($this->getDataArray());
    }
}
