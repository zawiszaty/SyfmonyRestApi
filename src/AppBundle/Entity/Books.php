<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Books
 *
 * @ORM\Table(name="books", indexes={@ORM\Index(name="fk_books_authors_idx", columns={"authors_idauthors1"}), @ORM\Index(name="fk_books_category1_idx", columns={"category_idcategory"})})
 * @ORM\Entity
 * @UniqueEntity("name")
 */
class Books
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="idbooks", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idbooks;

    /**
     * @var \AppBundle\Entity\Authors
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Authors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="authors_idauthors", referencedColumnName="idauthors")
     * })
     */
    private $authorsauthors;

    /**
     * @var \AppBundle\Entity\Category
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_idcategory", referencedColumnName="idcategory")
     * })
     */
    private $categorycategory;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getIdbooks(): ?int
    {
        return $this->idbooks;
    }

    /**
     * @param int $idbooks
     */
    public function setIdbooks(int $idbooks)
    {
        $this->idbooks = $idbooks;
    }

    /**
     * @return Authors
     */
    public function getAuthorsauthors(): ?Authors
    {
        return $this->authorsauthors;
    }

    /**
     * @param Authors $authorsauthors
     */
    public function setAuthorsauthors(Authors $authorsauthors)
    {
        $this->authorsauthors = $authorsauthors;
    }

    /**
     * @return Category
     */
    public function getCategorycategory(): ?Category
    {
        return $this->categorycategory;
    }

    /**
     * @param Category $categorycategory
     */
    public function setCategorycategory(Category $categorycategory)
    {
        $this->categorycategory = $categorycategory;
    }


}

