<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     * @Assert\NotBlank
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="cover_path", type="string", length=255)
     */
    private $coverPath;

    /**
     * @var string
     *
     * @ORM\Column(name="book_path", type="string", length=255)
     */
    private $bookPath;

    /**
     * @var File
     *
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $coverFile;

    /**
     * @var File
     *
     * @Assert\File(maxSize="5Mi")
     */
    private $bookFile;

    /**
     * @var \Date
     *
     * @ORM\Column(name="read_date", type="date")
     * @Assert\NotBlank
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
    public function setCoverPath($cover)
    {
        $this->coverPath = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string
     */
    public function getCoverPath()
    {
        return $this->coverPath;
    }

    /**
     * Set bookPath
     *
     * @param string $bookPath
     *
     * @return Book
     */
    public function setBookPath($bookPath)
    {
        $this->bookPath = $bookPath;

        return $this;
    }

    /**
     * Get bookPath
     *
     * @return string
     */
    public function getBookPath()
    {
        return $this->bookPath;
    }

    /**
     * Set cover file
     *
     * @param File $cover
     *
     * @return Book
     */
    public function setCoverFile(File $cover)
    {
        $this->coverFile = $cover;

        return $this;
    }

    /**
     * Get cover file
     *
     * @return File
     */
    public function getCoverFile()
    {
        return $this->coverFile;
    }

    /**
     * Set book file
     *
     * @param File $book
     *
     * @return Book
     */
    public function setBookFile($book)
    {
        $this->bookFile = $book;

        return $this;
    }

    /**
     * Get bookPath
     *
     * @return File
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
