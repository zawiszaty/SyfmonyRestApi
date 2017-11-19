<?php


namespace AppBundle\Manager;

use \AppBundle\Entity\Books;
use \AppBundle\Entity\Authors;
use \AppBundle\Entity\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * Class BooksManager
 * @package AppBundle\Manager
 */
class BooksManager
{
    /**
     * EntityManager object
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $_doctrine;

    /**
     * This is constructor methods
     *
     * BooksManager constructor.
     *
     * @param \Doctrine\ORM\EntityManager $doctrine
     */
    public function __construct(\Doctrine\ORM\EntityManager $doctrine)
    {
        $this->_doctrine = $doctrine;
    }


    /**
     * This method add new book
     *
     * @param array $params
     *
     * @return bool
     */
    public function addBooks(array $params): bool
    {
        $books = new Books();
        $authors = $this->_doctrine->getRepository(Authors::class)->find($params['authorsauthors']);
        $category = $this->_doctrine->getRepository(Category::class)->find($params['categorycategory']);
        $books->setName($params['name']);
        $books->setDescription($params['description']);
        $books->setAuthorsauthors($authors);
        $books->setCategorycategory($category);
        $this->_doctrine->persist($books);
        $this->_doctrine->flush();

        return true;
    }


    /**
     * This method delete book
     *
     * @param int $id
     *
     * @return bool
     */
    public function delBook(int $id): bool
    {
        $books = $this->_doctrine->getRepository(Books::class)->find($id);
        if (!$books) {
            throw new NotFoundHttpException();
        }
        $this->_doctrine->remove($books);
        $this->_doctrine->flush();

        return true;
    }


    /**
     * This method change existing book
     *
     * @param Books $oldBooks
     * @param array $params
     *
     * @return bool
     */
    public function editBook(\AppBundle\Entity\Books $oldBooks, array $params): bool
    {
        $oldBooks->setName($params['name']);
        $oldBooks->setDescription($params['description']);
        $authors = $this->_doctrine->getRepository(Authors::class)->find($params['authorsauthors']['idauthors']);
        $category = $this->_doctrine->getRepository(Category::class)->find($params['categorycategory']['idcategory']);
        if (!$authors || !$category) {
            throw new NotFoundHttpException();
        }
        $oldBooks->setAuthorsauthors($authors);
        $oldBooks->setCategorycategory($category);
        $this->_doctrine->persist($oldBooks);
        $this->_doctrine->flush();
        return true;
    }
}