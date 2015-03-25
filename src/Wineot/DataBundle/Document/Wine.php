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
     * @Assert\NotBlank()
     */
    private $resume;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      max = 255
     * )
     * @Assert\NotBlank()
     */
    private $cepage;

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
     * Set cepage
     *
     * @param string $cepage
     * @return self
     */
    public function setCepage($cepage)
    {
        $this->cepage = $cepage;
        return $this;
    }

    /**
     * Get cepage
     *
     * @return string $cepage
     */
    public function getCepage()
    {
        return $this->cepage;
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
