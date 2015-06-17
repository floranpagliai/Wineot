<?php
/**
 * User: floran
 * Date: 24/03/15
 * Time: 21:22
 */

namespace Wineot\DataBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @MongoDB\Document(collection="users")
 * @MongoDBUnique(fields="mail", message="user.warn.unique_email")
 */
class User implements UserInterface
{
    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      max = 25
     * )
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      min = "5",
     *      max = "30",
     *      minMessage = "user.warn.password_length",
     *      maxMessage = "user.warn.password_length",
     *      groups = {"Default"}
     * )
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "5",
     *      max = "30",
     *      minMessage = "user.warn.password_length",
     *      maxMessage = "user.warn.password_length",
     *      groups = {"Default"}
     * )
     * */
    private $plainPassword;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $mail;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      max = 25
     * )
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *      max = 25
     * )
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var collection
     *
     * @MongoDB\ReferenceMany(targetDocument="Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @var collection
     *
     * @MongoDB\ReferenceMany(name="favorite_wine_ids", targetDocument="Wine", simple=true)
     */
    private $favoritesWines;

    /**
     * @var collection
     *
     * @MongoDB\Field(type="collection")
     *
     * @Assert\NotBlank()
     */
    private $roles;

    /**
     * @var integer
     *
     * @MongoDB\Id
     */
    private $id;

    public function __construct()
    {
        $this->roles[] = 'ROLE_USER';
        $this->comments = new ArrayCollection();
        $this->favoritesWines = new ArrayCollection();
    }

    /**
     * Set username
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return self
     */
    public function setMail($email)
    {
        $this->mail = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string $email
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
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
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
    
    /**
     * Add comment
     *
     * @param \Wineot\DataBundle\Document\Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Remove comment
     *
     * @param \Wineot\DataBundle\Document\Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection $comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Returns the roles granted to the user.
     *
     * @return Roles[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set roles
     *
     * @param $roles
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $favoritesWines
     */
    public function setFavoritesWines($favoritesWines)
    {
        $this->favoritesWines = $favoritesWines;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavoritesWines()
    {
        return $this->favoritesWines;
    }

    /**
     * Add favorite wine
     *
     * @param \Wineot\DataBundle\Document\Wine $wine
     */
    public function addFavoriteWine(Wine $wine)
    {
        if (!$this->isFavorited($wine))
            $this->favoritesWines->add($wine);
    }

    /**
     * Remove favorite wine
     *
     * @param \Wineot\DataBundle\Document\Wine $wine
     */
    public function removeFavoriteWine(Wine $wine)
    {
        $this->favoritesWines->removeElement($wine);
    }


    public function isFavorited(Wine $wine)
    {
        if ($this->favoritesWines->contains($wine))
            return true;
        else
            return false;
    }

    /**
     * @return array
     */
    public static function getRolesType()
    {
        return array(
            'ROLE_ADMIN' => 'Admin',
        );
    }
}
