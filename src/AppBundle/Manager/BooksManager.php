<?php


namespace AppBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use \AppBundle\Entity\Books;
use \AppBundle\Entity\Authors;
use \AppBundle\Entity\Category;

/**
 * Class BooksManager
 *
 * @package AppBundle\Manager
 */
class BooksManager
{
    /**
     * This method add new book
     *
     * @param Registry $doctrine
     * @param array $params
     * @return bool
     */
    public function addBooks(Registry $doctrine, array $params): bool
    {
        $books = new Books();
        $authors = $doctrine->getRepository(Authors::class)->find($params['authorsauthors']);
        $category = $doctrine->getRepository(Category::class)->find($params['categorycategory']);
        $books->setName($params['name']);
        $books->setDescription($params['description']);
        $books->setAuthorsauthors($authors);
        $books->setCategorycategory($category);
        $doctrine->getManager()->persist($books);
        $doctrine->getManager()->flush();

        return true;
    }

    /**
     * This method delete book
     *
     * @param Registry $doctrine
     * @param int $id
     * @return bool
     */
    public function delBook(Registry $doctrine, int $id): bool
    {
        $books = $doctrine->getRepository(Books::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($books);
        $em->flush();

        return true;
    }

    /**
     * This method edit book
     *
     * @param Registry $doctrine
     * @param \AppBundle\Entity\Books $oldBooks
     * @param array $params
     * @return bool
     */
    public function editBook(Registry $doctrine, \AppBundle\Entity\Books $oldBooks, array $params): bool
    {
        $oldBooks->setName($params['name']);
        $oldBooks->setDescription($params['description']);
        $authors = $doctrine->getRepository(Authors::class)->find($params['authorsauthors']['idauthors']);
        $category = $doctrine->getRepository(Category::class)->find($params['categorycategory']['idcategory']);
        $oldBooks->setAuthorsauthors($authors);
        $oldBooks->setCategorycategory($category);
        $em = $doctrine->getManager();
        $em->persist($oldBooks);
        $em->flush();
        return true;
    }
}