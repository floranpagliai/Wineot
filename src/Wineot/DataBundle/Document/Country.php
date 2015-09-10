<?php
/**
 * User: floran
 * Date: 18/05/15
 * Time: 17:43
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="countries")
 */
class Country {
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
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    private $code;

    /**
     * @var collection
     *
     * @MongoDB\ReferenceMany(
     *  targetDocument="Region",
     *  inversedBy="country",
     *  cascade={"all"},
     *  simple=true)
     */
    private $regions;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
    }
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add region
     *
     * @param Region $region
     */
    public function addRegion(Region $region)
    {
        $this->regions[] = $region;
        $region->setCountry($this);
    }

    /**
     * Remove region
     *
     * @param Region $region
     */
    public function removeRegion(Region $region)
    {
        $this->regions->removeElement($region);
        $region->setCountry(null);
    }

    /**
     * @param \Doctrine\ODM\MongoDB\Mapping\Annotations\Collection $regions
     */
    public function setRegions($regions)
    {
        $this->regions = $regions;
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Mapping\Annotations\Collection
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }


} 