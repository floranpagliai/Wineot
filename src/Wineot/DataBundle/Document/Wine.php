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
     *  cascade={"persist"},
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
     * @var collection
     *
     * @MongoDB\EmbedMany(
     *  targetDocument="Vintage")
     */
    private $vintages;

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
     * @var collection
     *
     * @MongoDB\Field(name="comments")
     * @MongoDB\ReferenceMany(targetDocument="Comment", mappedBy="vintage", nullable=true)
     */
    private $comments;

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
     * Get winery
     *
     * @return \Wineot\DataBundle\Document\Winery $winery
     */
    public function getWinery()
    {
        return $this->winery;
    }

//    public function getComments()
//    {
//        $comments = array();
//        foreach ($this->vintages as $vintage) {
//            $vintage_comments = $vintage->getComments();
//            if(!isset($vintage_comments))
//                $comments[] = $vintage_comments;
//        }
//
//        return $comments;
//    }

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
