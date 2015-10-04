<?php
/**
 * User: floran
 * Date: 02/10/15
 * Time: 18:07
 */

namespace Wineot\DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\EmbeddedDocument()
 */
class FoodPairing
{
    const FOOD_TYPE_MEET = 0;
    const FOOD_TYPE_FISH = 1;
    const FOOD_TYPE_VEGETABLE = 2;
    const FOOD_TYPE_CHEESE = 3;
    const FOOD_TYPE_DESERT = 4;

    /**
     * @var integer
     *
     * @MongoDB\Field(type="int", name="food_type")
     * @Assert\NotBlank()
     */
    private $foodType;

    /**
     * FoodPairing constructor.
     * @param int $foodType
     */
    public function __construct($foodType)
    {
        $this->foodType = $foodType;
    }


    /**
     * @return int
     */
    public function getFoodType()
    {
        return $this->foodType;
    }

    /**
     * @param int $foodType
     */
    public function setFoodType($foodType)
    {
        $this->foodType = $foodType;
    }

    /**
     * @return array
     */
    public static function getFoodTypes()
    {
        return array(
            FoodPairing::FOOD_TYPE_MEET => 'MEET',
            FoodPairing::FOOD_TYPE_FISH => 'FISH',
            FoodPairing::FOOD_TYPE_VEGETABLE => 'VEGETABLE',
            FoodPairing::FOOD_TYPE_CHEESE => 'CHEESE',
            FoodPairing::FOOD_TYPE_DESERT => 'DESERT'
        );
    }



}