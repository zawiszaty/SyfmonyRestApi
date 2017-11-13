<?php

namespace AppBundle\Utils;


use Doctrine\Bundle\DoctrineBundle\Registry;

class Category
{
    public function getAllCategory(Registry $doctrine): array
    {
        $category = $doctrine
            ->getRepository(\AppBundle\Entity\Category::class)
            ->findAll();

        return $category;
    }

    public function getSingleCategory(Registry $doctrine, int $id): \AppBundle\Entity\Category
    {
        $category = $doctrine
            ->getRepository(\AppBundle\Entity\Category::class)
            ->find($id);

        return $category;
    }

    public function addCategory(Registry $doctrine, array $params): bool
    {
        $category = new \AppBundle\Entity\Category();
        $category->setName($params['name']);
        $category->setDescription($params['description']);
        $doctrine->getManager()->persist($category);
        $doctrine->getManager()->flush();

        return true;
    }

    public function delCategory(Registry $doctrine, int $id): bool
    {
        $category = $doctrine->getRepository(\AppBundle\Entity\Category::class)->find($id);
        $books = $doctrine->getRepository(\AppBundle\Entity\Books::class)->findBy(['categorycategory' => $id]);
        $defaultCategory = $doctrine->getRepository(\AppBundle\Entity\Category::class)->find(1);
        foreach ($books as $book) {
            $book->setCategorycategory($defaultCategory);
        }
        $em = $doctrine->getManager();

        $em->remove($category);
        $em->flush();

        return true;
    }

    public function editCategory(Registry $doctrine, \AppBundle\Entity\Category $oldCategory, array $params): bool
    {
        $oldCategory->setName($params['name']);
        $oldCategory->setDescription($params['description']);
        $em = $doctrine->getManager();
        $em->persist($oldCategory);
        $em->flush();
        return true;
    }

}