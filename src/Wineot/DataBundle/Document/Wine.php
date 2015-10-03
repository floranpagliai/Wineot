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
     * @MongoDB\ReferenceMany(
     *  targetDocument="Comment",
     *  mappedBy="wine",
     *  nullable=true)
     */
    private $comments;

    public function __construct()
    {
        $this->vintages = new ArrayCollection();
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
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection $comments
     */
    public function getComments()
    {
        if (!empty($this->comments))
            return $this->comments;
        else
            return null;
    }

    public function getAvgRating()
    {
        if ($this->comments->count() != 0) {
            $avgRating = 0;
            $comments = $this->comments;
            foreach($comments as $comment)
            {
                $avgRating += $comment->getRank();
            }
            return number_format($avgRating/$this->comments->count(), 1);
        } else
            return null;
    }

    public function getAvgPrice()
    {
        if ($this->vintages->count() != 0) {
            $avgPrice = 0;
            $vintages = $this->vintages;
            foreach($vintages as $vintage)
            {
                $avgPrice += $vintage->getWineryPrice();
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
}
