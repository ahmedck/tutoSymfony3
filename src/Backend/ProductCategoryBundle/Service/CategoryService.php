<?php
namespace Backend\ProductCategoryBundle\Service;
use AppBundle\Entity\ProductCategory ;

class CategoryService
{

    /**
     * @var @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em ;

    public function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine )
    {
        $this->repository = $doctrine->getRepository(ProductCategory::class);
        $this->em = $doctrine->getManager();
    }

    public function getAll(){
        return $this->repository->findAll();
    }

    public function countAll(){
        return count($this->repository->findAll());
    }

    public function delete($idCategory){
        $category = $this->repository->find($idCategory);
        if(!$category){
            throw new \Exception('No category found for id '.$idCategory);
        }
        $this->em->remove($category);
        $this->em->flush();
    }


}