<?php

namespace AppBundle\Entity;

/**
 * ProductCategory
 */
class ProductCategory
{
    /**
     * @var integer
     */
    private $idProductCategory;

    /**
     * @var string
     */
    private $category;


    /**
     * Get idProductCategory
     *
     * @return integer
     */
    public function getIdProductCategory()
    {
        return $this->idProductCategory;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return ProductCategory
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
}

