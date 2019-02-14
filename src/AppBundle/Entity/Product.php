<?php

namespace AppBundle\Entity;

/**
 * Product
 */
class Product
{
    /**
     * @var integer
     */
    private $idProduct;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $price;

    /**
     * @var \AppBundle\Entity\ProductCategory
     */
    private $idProductCategory;


    /**
     * Get idProduct
     *
     * @return integer
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set idProductCategory
     *
     * @param \AppBundle\Entity\ProductCategory $idProductCategory
     *
     * @return Product
     */
    public function setIdProductCategory(\AppBundle\Entity\ProductCategory $idProductCategory = null)
    {
        $this->idProductCategory = $idProductCategory;

        return $this;
    }

    /**
     * Get idProductCategory
     *
     * @return \AppBundle\Entity\ProductCategory
     */
    public function getIdProductCategory()
    {
        return $this->idProductCategory;
    }
}

