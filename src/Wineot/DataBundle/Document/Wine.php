<?php
/**
 * User: floran
 * Date: 26/03/15
 * Time: 00:09
 */

namespace Wineot\DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="wines")
 */
class Wine
{
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
     * @Assert\Length(
     *      max = 255
     * )
     */
    private $resume;

    /**
     * @var integer
     *
     * @MongoDB\Field(type="int")
     * @Assert\NotBlank()
     */
    private $color;

    /**
     * @var integer
     *
     * @MongoDB\Field(type="int", name="production_year")
     * @Assert\NotBlank()
     */
    private $productionYear;

    /**
     * @var array
     * @MongoDB\ReferenceOne(targetDocument="Comment", inversedBy="wineId")
     */
    private $comments;

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

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
     * Set resume
     *
     * @param string $resume
     * @return self
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
        return $this;
    }

    /**
     * Get resume
     *
     * @return string $resume
     */
    public function getResume()
    {
        return $this->resume;
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
     * Set comments
     *
     * @param Wineot\DataBundle\Document\Comment $comments
     * @return self
     */
    public function setComments(\Wineot\DataBundle\Document\Comment $comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * Get comments
     *
     * @return Wineot\DataBundle\Document\Comment $comments
     */
    public function getComments()
    {
        return $this->comments;
    }
}
