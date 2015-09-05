<?php
/**
 * User: floran
 * Date: 31/03/15
 * Time: 18:08
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\Collection;
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
     * @var string
     *
     * @MongoDB\String(nullable=true)
     * @Assert\Length(
     *      max = 255
     * )
     */
    private $mail;

    /**
     * @var string
     *
     * @MongoDB\String(nullable=true)
     * @Assert\Length(
     *      max = 255
     * )
     */
    private $phone;

    /**
     * @var Address
     *
     * @MongoDB\EmbedOne(
     *  targetDocument="Address")
     */
    private $address;

    /**
     * @var collection
     *
     * @MongoDB\ReferenceMany(
     *  targetDocument="Wine",
     *  mappedBy="winery")
     */
    private $wines;

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
     * @var Image
     *
     * @MongoDB\ReferenceOne(
     *  targetDocument="Image",
     *  cascade={"all"},
     *  simple=true)
     */
    private $coverPicture;

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
     * @param \Doctrine\Common\Collections\Collection $wines
     * @return self
     */
    public function setWines($wines)
    {
        $this->wines = $wines;
        return $this;
    }

    /**
     * Get wines
     *
     * @return \Doctrine\Common\Collections\Collection $wines
     */
    public function getWines()
    {
        if (!empty($this->wines))
            return $this->wines;
        else
            return null;
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
     * @return self
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return \Wineot\DataBundle\Document\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param \Wineot\DataBundle\Document\Image $coverPicture
     */
    public function setCoverPicture($coverPicture)
    {
        $this->coverPicture = $coverPicture;
    }

    /**
     * @return \Wineot\DataBundle\Document\Image
     */
    public function getCoverPicture()
    {
        return $this->coverPicture;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param \Wineot\DataBundle\Document\Address $address
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return \Wineot\DataBundle\Document\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    public function getAvgRating()
    {
        $avgRating = null;
        foreach ($this->wines as $wine) {
            $avgRating += $wine->getAvgRating();
        }
        if ($avgRating)
            return number_format($avgRating / $this->wines->count(), 1);
        else
            return null;
    }
}
