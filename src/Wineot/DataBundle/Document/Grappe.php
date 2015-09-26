<?php
/**
 * User: floran
 * Date: 11/09/15
 * Time: 10:51
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="grappes")
*/
class Grappe
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
     *  targetDocument="WineGrappe",
     *  mappedBy="grappe")
     */
    private $wines;


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
     * @param \Doctrine\Common\Collections\Collection $wines
     */
    public function setWines($wines)
    {
        $this->wines = $wines;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWines()
    {
        return $this->wines;
    }
} 