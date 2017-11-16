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
     * EntityManager object
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $_doctrine;

    /**
     * CategoryManager constructor.
     *
     * @param \Doctrine\ORM\EntityManager $doctrine
     */
    public function __construct(\Doctrine\ORM\EntityManager $doctrine)
    {
        $this->_doctrine = $doctrine;
    }

    /**
     * This method add new category
     *
     * @param array $params
     *
     * @return bool
     */
    public function addCategory(array $params): bool
    {
        $category = new Category();
        $category->setName($params['name']);
        $category->setDescription($params['description']);
        $this->_doctrine->persist($category);
        $this->_doctrine->flush();

        return true;
    }

    /**
     * This method delete category
     *
     * @param int $id
     *
     * @return bool
     */
    public function delCategory(int $id): bool
    {
        $category = $this->_doctrine->getRepository(Category::class)->find($id);
        $books = $this->_doctrine->getRepository(Books::class)->findBy(['categorycategory' => $id]);
        $defaultCategory = $this->_doctrine->getRepository(Category::class)->find(1);
        foreach ($books as $book) {
            $book->setCategorycategory($defaultCategory);
        }
        $this->_doctrine->remove($category);
        $this->_doctrine->flush();

        return true;
    }


    /**
     * This method edit category
     *
     * @param $oldCategory
     * @param array $params
     *
     * @return bool
     */
    public function editCategory($oldCategory, array $params): bool
    {
        $oldCategory->setName($params['name']);
        $oldCategory->setDescription($params['description']);
        $this->_doctrine->persist($oldCategory);
        $this->_doctrine->flush();
        return true;
    }
}