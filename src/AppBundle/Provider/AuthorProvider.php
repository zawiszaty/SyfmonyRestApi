<?php


namespace AppBundle\Provider;

use Doctrine\Bundle\DoctrineBundle\Registry;
use \AppBundle\Entity\Authors;

/**
 * Class AuthorProvider
 *
 * @package AppBundle\Provider
 */
class AuthorProvider
{
    /**
     * EntityManager object
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $_doctrine;

    /**
     * AuthorProvider constructor.
     *
     * @param \Doctrine\ORM\EntityManager $doctrine
     */
    public function __construct(\Doctrine\ORM\EntityManager $doctrine)
    {
        $this->_doctrine = $doctrine;
    }

    /**
     * This method return all authors
     *
     * @return array
     */
    public function getAllAuthors(): array
    {
        $authors = $this->_doctrine
            ->getRepository(Authors::class)
            ->findAll();

        return $authors;
    }

    /**
     * This method return only one authors
     *
     * @param int $id
     *
     * @return \AppBundle\Entity\Authors
     */
    public function getSingleAuthor(int $id): Authors
    {
        $author = $this->_doctrine
            ->getRepository(Authors::class)
            ->find($id);

        return $author;
    }
}