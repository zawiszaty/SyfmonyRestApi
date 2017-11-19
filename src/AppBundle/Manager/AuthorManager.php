<?php


namespace AppBundle\Manager;

use \AppBundle\Entity\Authors;
use \AppBundle\Entity\Books;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AuthorManager
 * @package AppBundle\Manager
 */
class AuthorManager
{
    /**
     * EntityManager object
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $_doctrine;

    /**
     * AuthorManager constructor.
     *
     * @param \Doctrine\ORM\EntityManager $doctrine
     */
    public function __construct(\Doctrine\ORM\EntityManager $doctrine)
    {
        $this->_doctrine = $doctrine;
    }

    /**
     * This method add new author
     *
     * @param  array $params
     *
     * @return bool
     */
    public function addAuthor(array $params): bool
    {
        $author = new Authors();
        $author->setName($params['name']);
        $author->setDescription($params['description']);

        $this->_doctrine->persist($author);
        $this->_doctrine->flush();

        return true;
    }

    /**
     * This method delete author
     *
     * @param int $id
     *
     * @return bool
     */
    public function delAuthor(int $id): bool
    {
        $author = $this->_doctrine->getRepository(Authors::class)->find($id);
        $books = $this->_doctrine->getRepository(Books::class)->findBy(['authorsauthors' => $id]);
        if (!$author || !$books) {
            throw new NotFoundHttpException();
        }
        $defaultAuthor = $this->_doctrine->getRepository(Authors::class)->find(1);
        foreach ($books as $book) {
            $book->setAuthorsauthors($defaultAuthor);
        }


        $this->_doctrine->remove($author);
        $this->_doctrine->flush();

        return true;
    }

    /**
     * This method edit author
     *
     * @param \AppBundle\Entity\Authors $author
     * @param array $params
     *
     * @return bool
     */
    public function editAuthor(Authors $author, array $params): bool
    {
        $author->setName($params['name']);
        $author->setDescription($params['description']);

        $this->_doctrine->persist($author);
        $this->_doctrine->flush();
        return true;
    }
}