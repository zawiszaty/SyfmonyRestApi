<?php


namespace AppBundle\Provider;

use \AppBundle\Entity\Authors;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        if (!$authors)
        {
            throw new NotFoundHttpException();
        }
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
        if (!$author)
        {
            throw new NotFoundHttpException();
        }
        return $author;
    }
}