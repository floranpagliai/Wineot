<?php
/**
 * User: floran
 * Date: 18/05/15
 * Time: 17:49
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="regions")
 */
class Region
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
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var Country
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Country",
     *  mappedBy="regions"))
     */
    private $country;

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
} 