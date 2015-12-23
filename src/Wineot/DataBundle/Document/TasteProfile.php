<?php
/**
 * User: floran
 * Date: 25/11/2015
 * Time: 21:40
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @MongoDB\EmbeddedDocument
 */
class TasteProfile
{
    /**
     * @var Int
     * @JMS\Type("integer")
     *
     * @MongoDB\Field(type="int", name="sweet_level"))
     */
    private $sweetLevel;

    /**
     * @var Int
     * @JMS\Type("integer")
     *
     * @MongoDB\Field(type="int", name="fruits_level"))
     */
    private $fruitsLevel;

    /**
     * @var Int
     * @JMS\Type("integer")
     *
     * @MongoDB\Field(type="int", name="wooded_level"))
     */
    private $woodedLevel;

    /**
     * @var Int
     * @JMS\Type("integer")
     *
     * @MongoDB\Field(type="int", name="strength_level"))
     */
    private $strengthLevel;

    /**
     * @var Int
     * @JMS\Type("integer")
     *
     * @MongoDB\Field(type="int", name="tannins_level"))
     */
    private $tanninsLevel;

    /**
     * @var Int
     * @JMS\Type("integer")
     *
     * @MongoDB\Field(type="int", name="complex_level"))
     */
    private $complexLevel;


    /**
     * @return Int
     */
    public function getSweetLevel()
    {
        return $this->sweetLevel;
    }

    /**
     * @param Int $sweetLevel
     */
    public function setSweetLevel($sweetLevel)
    {
        $this->sweetLevel = $sweetLevel;
    }

    /**
     * @return Int
     */
    public function getFruitsLevel()
    {
        return $this->fruitsLevel;
    }

    /**
     * @param Int $fruitsLevel
     */
    public function setFruitsLevel($fruitsLevel)
    {
        $this->fruitsLevel = $fruitsLevel;
    }

    /**
     * @return Int
     */
    public function getWoodedLevel()
    {
        return $this->woodedLevel;
    }

    /**
     * @param Int $woodedLevel
     */
    public function setWoodedLevel($woodedLevel)
    {
        $this->woodedLevel = $woodedLevel;
    }

    /**
     * @return Int
     */
    public function getStrengthLevel()
    {
        return $this->strengthLevel;
    }

    /**
     * @param Int $strengthLevel
     */
    public function setStrengthLevel($strengthLevel)
    {
        $this->strengthLevel = $strengthLevel;
    }

    /**
     * @return Int
     */
    public function getTanninsLevel()
    {
        return $this->tanninsLevel;
    }

    /**
     * @param Int $tanninsLevel
     */
    public function setTanninsLevel($tanninsLevel)
    {
        $this->tanninsLevel = $tanninsLevel;
    }

    /**
     * @return Int
     */
    public function getComplexLevel()
    {
        return $this->complexLevel;
    }

    /**
     * @param Int $complexLevel
     */
    public function setComplexLevel($complexLevel)
    {
        $this->complexLevel = $complexLevel;
    }

    public function toArray()
    {
        return array(
            array("name" => "sweet", "label" => "wine.form.sweet_level", "value" => $this->calculatePercentage($this->getSweetLevel())),
            array("name" => "fruits", "label" => "wine.form.fruits_level", "value" => $this->calculatePercentage($this->getFruitsLevel())),
            array("name" => "wooded", "label" => "wine.form.wooded_level", "value" => $this->calculatePercentage($this->getWoodedLevel())),
            array("name" => "strength", "label" => "wine.form.strength_level", "value" => $this->calculatePercentage($this->getStrengthLevel())),
            array("name" => "tannins", "label" => "wine.form.tannins_level", "value" => $this->calculatePercentage($this->getTanninsLevel())),
            array("name" => "complex", "label" => "wine.form.complex_level", "value" => $this->calculatePercentage($this->getComplexLevel()))
        );
    }

    public function calculatePercentage($value)
    {
        return $value * 100 / 4;
    }
}