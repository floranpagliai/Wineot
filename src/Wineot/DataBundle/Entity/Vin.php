<?php

namespace Wineot\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vin
 *
 * @ORM\Table(name="Vin")
 * @ORM\Entity
 */
class Vin
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="cepage", type="string", length=255, nullable=false)
     */
    private $cepage;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_origine", type="string", length=255, nullable=false)
     */
    private $villeOrigine;

    /**
     * @var integer
     *
     * @ORM\Column(name="producteur_id", type="integer", nullable=false)
     */
    private $producteurId;

    /**
     * @var integer
     *
     * @ORM\Column(name="revendeur_id", type="integer", nullable=false)
     */
    private $revendeurId;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}
