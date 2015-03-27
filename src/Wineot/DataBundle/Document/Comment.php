<?php
/**
 * User: floran
 * Date: 27/03/15
 * Time: 20:04
 */

namespace Wineot\DataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="comments")
 */
class Comment
{
    /** @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      max = 255
     * )
     */
    private $comment;

    /**
     * @var integer
     *
     * @MongoDB\Field(type="int")
     * @Assert\NotBlank()
     */
    private $rank;

    /**
     * @var integer
     *
     * @MongoDB\Field(name="user_id")
     * @MongoDB\ReferenceMany(targetDocument="User", mappedBy="comments")
     */
    private $userId;

    /**
     * @var integer
     *
     * @MongoDB\Field(name="wine_id")
     * @MongoDB\ReferenceMany(targetDocument="Wine", mappedBy="comments")
     */
    private $wineId;

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    public function __construct()
    {
        $this->userId = new \Doctrine\Common\Collections\ArrayCollection();
        $this->wineId = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set comment
     *
     * @param string $comment
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Get comment
     *
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set rank
     *
     * @param int $rank
     * @return self
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
        return $this;
    }

    /**
     * Get rank
     *
     * @return int $rank
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Add userId
     *
     * @param Wineot\DataBundle\Document\User $userId
     */
    public function addUserId(\Wineot\DataBundle\Document\User $userId)
    {
        $this->userId[] = $userId;
    }

    /**
     * Remove userId
     *
     * @param Wineot\DataBundle\Document\User $userId
     */
    public function removeUserId(\Wineot\DataBundle\Document\User $userId)
    {
        $this->userId->removeElement($userId);
    }

    /**
     * Get userId
     *
     * @return \Doctrine\Common\Collections\Collection $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Add wineId
     *
     * @param Wineot\DataBundle\Document\Wine $wineId
     */
    public function addWineId(\Wineot\DataBundle\Document\Wine $wineId)
    {
        $this->wineId[] = $wineId;
    }

    /**
     * Remove wineId
     *
     * @param Wineot\DataBundle\Document\Wine $wineId
     */
    public function removeWineId(\Wineot\DataBundle\Document\Wine $wineId)
    {
        $this->wineId->removeElement($wineId);
    }

    /**
     * Get wineId
     *
     * @return \Doctrine\Common\Collections\Collection $wineId
     */
    public function getWineId()
    {
        return $this->wineId;
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
