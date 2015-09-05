<?php

namespace Wineot\DataBundle\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\EmbeddedDocument
 */
class Address {
    /**
     * @var string
     *
     * @MongoDB\String(nullable=true)
     * @Assert\Length(
     *      max = 255
     * )
     */
    private $address;

    /**
     * @var string
     *
     * @MongoDB\String
     * @Assert\Length(
     *      max = 50
     * )
     */
    private $town;

    /**
     * @var string
     *
     * @MongoDB\String(nullable=true)
     * @Assert\Length(
     *      max = 25
     * )
     */
    private $zipcode;

    /**
     * @param string $address
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $town
     * @return self
     */
    public function setTown($town)
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $zipcode
     * @return self
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }
} 