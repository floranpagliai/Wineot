<?php
/**
 * User: floran
 * Date: 31/03/15
 * Time: 18:08
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="wineries")
 */
class Winery
{

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

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
     * @var collection
     *
     * @MongoDB\ReferenceMany(
     *  targetDocument="Wine",
     *  mappedBy="winery",
     *  cascade={"all"})
     */
    private $wines = array();

    /**
     * @var Country
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Country",
     *  simple=true)
     */
    private $country;

    /**
     * @var Region
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Region",
     *  simple=true)
     */
    private $region;
    
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

    /**
     * @param \Wineot\DataBundle\Document\Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return \Wineot\DataBundle\Document\Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param \Wineot\DataBundle\Document\Region $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return \Wineot\DataBundle\Document\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

}
