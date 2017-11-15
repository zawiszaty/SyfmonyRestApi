<?php


namespace AppBundle\Provider;

use \AppBundle\Entity\Books;

/**
 * Class BooksProvider
 *
 * @package AppBundle\Provider
 */
class BooksProvider
{

    private $_doctrine;

    public function __construct(\Doctrine\ORM\EntityManager $doctrine)
    {
        $this->_doctrine = $doctrine;
    }

    /**
     * This method return all books
     *
     * @return array
     */
    public function getAllBooks(): array
    {
        $books = $this->_doctrine
            ->getRepository(Books::class)
            ->findAll();
        return $books;
    }

    /**
     * This method return only one book
     *
     * @param int $id
     *
     * @return \AppBundle\Entity\Books
     */
    public function getSingleBook(int $id): Books
    {
        $books = $this->_doctrine->getRepository(Books::class)->find($id);
        return $books;
    }
}