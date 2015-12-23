<?php
/**
 * User: floran
 * Date: 27/03/15
 * Time: 20:04
 */

namespace Wineot\DataBundle\Document;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(collection="comments", repositoryClass="Wineot\DataBundle\Repository\CommentRepository")
 */
class Comment
{
    /** @MongoDB\Id */
    private $id;

    /** @var string
     *
     * @MongoDB\String(nullable=true)
     * @Assert\Length(max = 255)
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
     * @MongoDB\ReferenceOne(
     *  targetDocument="User",
     *  inversedBy="comments",
     *  simple=true)
     */
    private $user;

    /**
     * @var integer
     *
     * @MongoDB\Field()
     * @MongoDB\ReferenceOne(
     *  targetDocument="Vintage",
     *  inversedBy="comments",
     *  cascade={"persist"},
     *  simple=true)
     */
    private $wine;

    /**
     * @var Datetime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @MongoDB\Date(name="created_at")
     */
    private $createdAt;

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
     * Get vintage
     *
     * @return \Wineot\DataBundle\Document\Vintage $vintage
     */
    public function getWine()
    {
        return $this->wine;
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
     * Set Wine
     *
     * @param \Wineot\DataBundle\Document\Vintage $vintage
     * @return self
     */
    public function setWine(Vintage $vintage)
    {
        $this->wine = $vintage;
        return $this;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
