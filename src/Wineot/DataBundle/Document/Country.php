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
     * @MongoDB\Field(name="regions")
     * @MongoDB\ReferenceMany(
     *  targetDocument="Region",
     *  mappedBy="country",
     *  cascade={"persist", "remove"},
     *  simple=true)
     */
    private $regions;

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