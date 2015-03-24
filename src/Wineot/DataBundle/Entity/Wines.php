<?php

namespace Wineot\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wines
 *
 * @ORM\Table(name="wines")
 * @ORM\Entity
 */
class Wines
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="string", length=64, nullable=false)
     */
    private $resume;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}
