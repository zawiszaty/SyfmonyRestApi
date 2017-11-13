<?php

namespace AppBundle\Utils;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;


class Authors
{
    public function getAllAuthors(Registry $doctrine): array
    {
        $authors = $doctrine
            ->getRepository(\AppBundle\Entity\Authors::class)
            ->findAll();

        return $authors;
    }

    public function getSingleAuthor(Registry $doctrine, int $id): \AppBundle\Entity\Authors
    {
        $author = $doctrine
            ->getRepository(\AppBundle\Entity\Authors::class)
            ->find($id);

        return $author;
    }

    public function validateAuthor(int $id): bool
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($id, array(
            new NotBlank(),
        ));
        if (0 !== count($violations)) {
            return false;
        }
        return true;
    }

    public function addAuthor(Registry $doctrine, array $params): bool
    {
        $author = new \AppBundle\Entity\Authors();
        $author->setName($params['name']);
        $author->setDescription($params['description']);

        $doctrine->getManager()->persist($author);
        $doctrine->getManager()->flush();

        return true;
    }

    public function delAuthor(Registry $doctrine, int $id): bool
    {
        $author = $doctrine->getRepository(\AppBundle\Entity\Authors::class)->find($id);
        $books = $doctrine->getRepository(\AppBundle\Entity\Books::class)->findBy(['authorsauthors' => $id]);
        $defaultAuthor = $doctrine->getRepository(\AppBundle\Entity\Authors::class)->find(1);
        foreach ($books as $book) {
            $book->setAuthorsauthors($defaultAuthor);
        }
        $em = $doctrine->getManager();

        $em->remove($author);
        $em->flush();

        return true;
    }

    public function editAuthor(Registry $doctrine, \AppBundle\Entity\Authors $author, array $params): bool
    {
        $author->setName($params['name']);
        $author->setDescription($params['description']);
        $em = $doctrine->getManager();

        $em->persist($author);
        $em->flush();
        return true;
    }
}