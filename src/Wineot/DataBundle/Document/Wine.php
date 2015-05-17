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
     * @var collection
     *
     * @MongoDB\Field(name="vintages")
     * @MongoDB\EmbedMany(
     * targetDocument="Vintage")
     */
    private $vintages;

    /**
     * @var Image
     *
     * @MongoDB\Field(name="image")
     * @MongoDB\EmbedOne(
     * targetDocument="Image")
     */
    private $image;

    /**
     * @var integer
     *
     * @MongoDB\Field(type="int", name="winery_id")
     * @MongoDB\ReferenceOne(targetDocument="Winery", inversedBy="wines", cascade={"persist"}, simple=true)
     */
    private $winery;

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    public function __construct()
    {
        $this->vintages = new ArrayCollection();
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
    }

    /**
     * Remove vintage
     *
     * @param \Wineot\DataBundle\Document\Vintage $vintage
     */
    public function removeVintage(Vintage $vintage)
    {
        $this->vintages->removeElement($vintage);
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
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
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
     * Get wineryId
     *
     * @return \Wineot\DataBundle\Document\Winery $wineryId
     */
    public function getWinery()
    {
        return $this->winery;
    }

    public function getComments()
    {
        $comments = array();
        foreach ($this->vintages as $vintage) {
            $vintage_comments = $vintage->getComments();
            if(!isset($vintage_comments))
                $comments[] = $vintage_comments;
        }

        return $comments;
    }

    /**
     * @param \Wineot\DataBundle\Document\Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return \Wineot\DataBundle\Document\Image
     */
    public function getImage()
    {
        return $this->image;
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
}
