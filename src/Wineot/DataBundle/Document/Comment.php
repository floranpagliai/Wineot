<?php
/**
 * User: floran
 * Date: 27/03/15
 * Time: 20:04
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @MongoDB\ReferenceOne(targetDocument="User", inversedBy="comments")
     */
    private $user;

    /**
     * @var integer
     *
     * @MongoDB\Field(name="vintage_id")
     * @MongoDB\ReferenceOne(targetDocument="Vintage", inversedBy="comments")
     */
    private $vintage;

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
        $this->wineId = new ArrayCollection();
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
     * Set userId
     *
     * @param \Wineot\DataBundle\Document\User $user
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get userId
     *
     * @return \Wineot\DataBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set vintageId
     *
     * @param \Wineot\DataBundle\Document\Vintage $vintage
     * @return self
     */
    public function setVintageId(Vintage $vintage)
    {
        $this->vintage = $vintage;
        return $this;
    }

    /**
     * Get vintageId
     *
     * @return \Wineot\DataBundle\Document\Vintage $vintage
     */
    public function getVintage()
    {
        return $this->vintage;
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

    /**
     * Set vintage
     *
     * @param Wineot\DataBundle\Document\Vintage $vintage
     * @return self
     */
    public function setVintage(\Wineot\DataBundle\Document\Vintage $vintage)
    {
        $this->vintage = $vintage;
        return $this;
    }
}
