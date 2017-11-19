<?php


namespace AppBundle\Provider;

use Doctrine\Bundle\DoctrineBundle\Registry;
use \AppBundle\Entity\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CategoryProvider
 *
 * @package AppBundle\Provider
 */
class CategoryProvider
{
    /**
     * EntityManager object
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $_doctrine;

    /**
     * CategoryProvider constructor.
     *
     * @param \Doctrine\ORM\EntityManager $doctrine //
     */
    public function __construct(\Doctrine\ORM\EntityManager $doctrine)
    {
        $this->_doctrine = $doctrine;
    }

    /**
     * This method return all category
     *
     * @return array
     */
    public function getAllCategory(): array
    {
        $category = $this->_doctrine
            ->getRepository(Category::class)
            ->findAll();
        if (!$category)
        {
            throw new NotFoundHttpException();
        }
        return $category;
    }

    /**
     * This method return only one category object
     *
     * @param int $id //
     *
     * @return Category
     */
    public function getSingleCategory(int $id): Category
    {
        $category = $this->_doctrine
            ->getRepository(Category::class)
            ->find($id);
        if (!$category)
        {
            throw new NotFoundHttpException();
        }
        return $category;
    }
}