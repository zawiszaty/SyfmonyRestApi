<?php


namespace AppBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use \AppBundle\Entity\Authors;
use \AppBundle\Entity\Books;

/**
 * Class AuthorManager
 * @package AppBundle\Manager
 */
class AuthorManager
{
    /**
     * This method add new author
     *
     * @param  Registry $doctrine
     * @param  array $params
     * @return bool
     */
    public function addAuthor(Registry $doctrine, array $params): bool
    {
        $author = new Authors();
        $author->setName($params['name']);
        $author->setDescription($params['description']);

        $doctrine->getManager()->persist($author);
        $doctrine->getManager()->flush();

        return true;
    }

    /**
     * This method delete author
     *
     * @param Registry $doctrine
     * @param int $id
     * @return bool
     */
    public function delAuthor(Registry $doctrine, int $id): bool
    {
        $author = $doctrine->getRepository(Authors::class)->find($id);
        $books = $doctrine->getRepository(Books::class)->findBy(['authorsauthors' => $id]);
        $defaultAuthor = $doctrine->getRepository(Authors::class)->find(1);
        foreach ($books as $book) {
            $book->setAuthorsauthors($defaultAuthor);
        }
        $em = $doctrine->getManager();

        $em->remove($author);
        $em->flush();

        return true;
    }

    /**
     * This method edit author
     *
     * @param Registry $doctrine
     * @param \AppBundle\Entity\Authors $author
     * @param array $params
     * @return bool
     */
    public function editAuthor(Registry $doctrine, Authors $author, array $params): bool
    {
        $author->setName($params['name']);
        $author->setDescription($params['description']);
        $em = $doctrine->getManager();

        $em->persist($author);
        $em->flush();
        return true;
    }
}