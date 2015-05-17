<?php
/**
 * User: floran
 * Date: 16/05/15
 * Time: 18:42
 */

namespace Wineot\DataBundle\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\HasLifecycleCallbacks;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\EmbeddedDocument @HasLifecycleCallbacks
 */
class Image
{
    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    public $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    private $filenameForRemove;
    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
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
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }



    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->name;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return '/home/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/image';
    }

    /**
     * @MongoDB\PrePersist
     * @MongoDB\PreUpdate
     */
    public function upload() {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move(
            $this->getUploadRootDir(), $this->getFile()->getClientOriginalName()
        );

        $this->path = $this->getUploadRootDir();
        $this->name = $this->getFile()->getClientOriginalName();
        $this->file = null;
    }

}