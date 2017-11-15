<?php


namespace AppBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use \AppBundle\Entity\Category;
use \AppBundle\Entity\Books;

/**
 * Class CategoryManager
 *
 * @package AppBundle\Manager
 */
class CategoryManager
{
    /**
     * This method add new category
     *
     * @param Registry $doctrine
     * @param array $params
     *
     * @return bool
     */
    public function addCategory(Registry $doctrine, array $params): bool
    {
        $category = new Category();
        $category->setName($params['name']);
        $category->setDescription($params['description']);
        $doctrine->getManager()->persist($category);
        $doctrine->getManager()->flush();

        return true;
    }

    /**
     * This method delete category
     *
     * @param Registry $doctrine
     * @param int $id
     *
     * @return bool
     */
    public function delCategory(Registry $doctrine, int $id): bool
    {
        $category = $doctrine->getRepository(Category::class)->find($id);
        $books = $doctrine->getRepository(Books::class)->findBy(['categorycategory' => $id]);
        $defaultCategory = $doctrine->getRepository(Category::class)->find(1);
        foreach ($books as $book) {
            $book->setCategorycategory($defaultCategory);
        }
        $em = $doctrine->getManager();

        $em->remove($category);
        $em->flush();

        return true;
    }

    /**
     * This method edit category
     *
     * @param Registry $doctrine
     * @param \AppBundle\Entity\Category $oldCategory
     * @param array $params
     *
     * @return bool
     */
    public function editCategory(Registry $doctrine, $oldCategory, array $params): bool
    {
        $oldCategory->setName($params['name']);
        $oldCategory->setDescription($params['description']);
        $em = $doctrine->getManager();
        $em->persist($oldCategory);
        $em->flush();
        return true;
    }
}