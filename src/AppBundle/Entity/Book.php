<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookRepository")
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="cover_file", type="string", length=255)
     */
    private $coverFile;

    /**
     * @var string
     *
     * @ORM\Column(name="book_file", type="string", length=255)
     */
    private $bookFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="read_date", type="datetime")
     */
    private $readDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="isDownloadable", type="boolean")
     */
    private $isDownloadable;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Book
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Book
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set cover
     *
     * @param string $cover
     *
     * @return Book
     */
    public function setCoverFile($cover)
    {
        $this->coverFile = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string
     */
    public function getCoverFile()
    {
        return $this->coverFile;
    }

    /**
     * Set bookFile
     *
     * @param string $bookFile
     *
     * @return Book
     */
    public function setBookFile($bookFile)
    {
        $this->bookFile = $bookFile;

        return $this;
    }

    /**
     * Get bookFile
     *
     * @return string
     */
    public function getBookFile()
    {
        return $this->bookFile;
    }

    /**
     * Set readDate
     *
     * @param \DateTime $readDate
     *
     * @return Book
     */
    public function setReadDate($readDate)
    {
        $this->readDate = $readDate;

        return $this;
    }

    /**
     * Get readDate
     *
     * @return \DateTime
     */
    public function getReadDate()
    {
        return $this->readDate;
    }

    /**
     * Set isDownloadable
     *
     * @param boolean $isDownloadable
     *
     * @return Book
     */
    public function setIsDownloadable($isDownloadable)
    {
        $this->isDownloadable = $isDownloadable;

        return $this;
    }

    /**
     * Get isDownloadable
     *
     * @return bool
     */
    public function getIsDownloadable()
    {
        return $this->isDownloadable;
    }
}
