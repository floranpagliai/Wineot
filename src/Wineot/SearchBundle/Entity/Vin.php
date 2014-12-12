<?php

namespace Wineot\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vin
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Wineot\SearchBundle\Entity\VinRepository")
 */
class Vin
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="cepage", type="string", length=255)
     */
    private $cepage;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_origine", type="string", length=255)
     */
    private $villeOrigine;

    /**
     * @var integer
     *
     * @ORM\Column(name="producteur_id", type="integer")
     */
    private $producteurId;

    /**
     * @var integer
     *
     * @ORM\Column(name="revendeur_id", type="integer")
     */
    private $revendeurId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Vin
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set cepage
     *
     * @param string $cepage
     * @return Vin
     */
    public function setCepage($cepage)
    {
        $this->cepage = $cepage;

        return $this;
    }

    /**
     * Get cepage
     *
     * @return string 
     */
    public function getCepage()
    {
        return $this->cepage;
    }

    /**
     * Set villeOrigine
     *
     * @param string $villeOrigine
     * @return Vin
     */
    public function setVilleOrigine($villeOrigine)
    {
        $this->villeOrigine = $villeOrigine;

        return $this;
    }

    /**
     * Get villeOrigine
     *
     * @return string 
     */
    public function getVilleOrigine()
    {
        return $this->villeOrigine;
    }

    public function __construct()
    {

    }

    /**
     * Set producteurId
     *
     * @param integer $producteurId
     * @return Vin
     */
    public function setProducteurId($producteurId)
    {
        $this->producteurId = $producteurId;

        return $this;
    }

    /**
     * Get producteurId
     *
     * @return integer 
     */
    public function getProducteurId()
    {
        return $this->producteurId;
    }

    /**
     * Set revendeurId
     *
     * @param integer $revendeurId
     * @return Vin
     */
    public function setRevendeurId($revendeurId)
    {
        $this->revendeurId = $revendeurId;

        return $this;
    }

    /**
     * Get revendeurId
     *
     * @return integer 
     */
    public function getRevendeurId()
    {
        return $this->revendeurId;
    }

    public function __toString()
    {
        return strval($this->id);
    }

}
