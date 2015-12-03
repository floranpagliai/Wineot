<?php
/**
 * User: floran
 * Date: 16/05/15
 * Time: 18:42
 */

namespace Wineot\DataBundle\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\File;
use Doctrine\ODM\MongoDB\Mapping\Annotations\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @MongoDB\Document(collection="images")
 * @HasLifecycleCallbacks
 *
 * @ExclusionPolicy("all")
 */
class Image
{
    /** @MongoDB\Id */
    private $id;

    /** @MongoDB\File */
    private $file;

    private $fileuploaded;

    /** @MongoDB\String */
    private $filename = null;

    /** @MongoDB\String */
    private $mimeType;

    /** @MongoDB\Date */
    private $uploadDate;

    /** @MongoDB\Int */
    private $length;

    /** @MongoDB\Int */
    private $chunkSize;

    /** @MongoDB\String */
    private $md5;

    /**
     * @return mixed
     */
    public function getChunkSize()
    {
        return $this->chunkSize;
    }

    /**
     * @param File $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $fileuploaded
     */
    public function setFileuploaded($fileuploaded)
    {
        $this->fileuploaded = $fileuploaded;
    }

    /**
     * @return mixed
     */
    public function getFileuploaded()
    {
        return $this->fileuploaded;
    }


    /**
     * @param File $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return File
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getMd5()
    {
        return $this->md5;
    }

    /**
     * @param mixed $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return mixed
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    /**
     * @MongoDB\PrePersist
     * @MongoDB\PreUpdate
     */
    public function upload() {
        if (null === $this->fileuploaded) {
            return;
        }
            $this->setFilename(md5_file($this->fileuploaded->getPathname()));
            $this->setMimeType($this->fileuploaded->getClientMimeType());
            $this->setFile($this->fileuploaded->getPathname());
        $this->fileuploaded = null;
    }

    /**
     *
     * @return null|string
     */
    public function getImage()
    {
        if ($this->file)
            return "data:".$this->getMimeType().";base64," . base64_encode($this->file->getMongoGridFSFile()->getBytes());
        else
            return null;
    }

}