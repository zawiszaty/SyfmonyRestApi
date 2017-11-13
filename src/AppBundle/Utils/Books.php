<?php


namespace AppBundle\Utils;


use Doctrine\Bundle\DoctrineBundle\Registry;

class Books
{
    public function getAllBooks(Registry $doctrine): array
    {
        $books = $doctrine
            ->getRepository(\AppBundle\Entity\Books::class)
            ->findAll();
        return $books;
    }

    public function getSingleBook(Registry $doctrine, int $id): \AppBundle\Entity\Books
    {
        $books = $doctrine->getRepository(\AppBundle\Entity\Books::class)->find($id);
        return $books;
    }

    public function addBooks(Registry $doctrine, array $params): bool
    {
        $books = new \AppBundle\Entity\Books();
        $authors = $doctrine->getRepository(\AppBundle\Entity\Authors::class)->find($params['authorsauthors']);
        $category = $doctrine->getRepository(\AppBundle\Entity\Category::class)->find($params['categorycategory']);
        $books->setName($params['name']);
        $books->setDescription($params['description']);
        $books->setAuthorsauthors($authors);
        $books->setCategorycategory($category);
        $doctrine->getManager()->persist($books);
        $doctrine->getManager()->flush();

        return true;
    }

    public function delBook(Registry $doctrine, int $id): bool
    {
        $books = $doctrine->getRepository(\AppBundle\Entity\Books::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($books);
        $em->flush();

        return true;
    }

    public function editBook(Registry $doctrine, \AppBundle\Entity\Books $oldBooks, array $params): bool
    {
        $oldBooks->setName($params['name']);
        $oldBooks->setDescription($params['description']);
        $authors = $doctrine->getRepository(\AppBundle\Entity\Authors::class)->find($params['authorsauthors']['idauthors']);
        $category = $doctrine->getRepository(\AppBundle\Entity\Category::class)->find($params['categorycategory']['idcategory']);
        $oldBooks->setAuthorsauthors($authors);
        $oldBooks->setCategorycategory($category);
        $em = $doctrine->getManager();
        $em->persist($oldBooks);
        $em->flush();
        return true;
    }
}