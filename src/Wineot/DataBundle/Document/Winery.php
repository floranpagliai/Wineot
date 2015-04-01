<?php
/**
 * User: floran
 * Date: 31/03/15
 * Time: 18:08
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="wineries")
 */
class Winery {
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
     * @var array
     *
     * @MongoDB\Field(name="wines")
     * @MongoDB\ReferenceMany(targetDocument="Wine", mappedBy="winery")
     */
    private $wines;

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
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
     * Add wine
     *
     * @param \Wineot\DataBundle\Document\Wine $wine
     */
    public function addWine(Wine $wine)
    {
        $this->wines[] = $wine;
    }

    /**
     * Remove wine
     *
     * @param \Wineot\DataBundle\Document\Wine $wine
     */
    public function removeWine(Wine $wine)
    {
        $this->wines->removeElement($wine);
    }

    /**
     * Get wines
     *
     * @return \Doctrine\Common\Collections\Collection $wines
     */
    public function getWines()
    {
        return $this->wines;
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
