<?php

namespace Backend\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Product ;
use AppBundle\Entity\ProductCategory ;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('BackendProductBundle:Default:index.html.twig' , array(
            'products' => $products
        ));
    }

    public function deleteAction(Request $request)
    {
        $idProduct = $request->get('idProduct');
        try{
            $product = $this->getDoctrine()->getRepository(Product::class)->find($idProduct);
            if(!$product){
                throw $this->createNotFoundException(
                    'No product found for id '.$idProduct
                );
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();

            $this->addFlash(
                'success',
               'OPERATION_DONE'
            );
        }catch(\Exception $e){
            $this->addFlash(
                'error',
               $e->getMessage()
            );
        }
        return $this->redirectToRoute('backend_product_homepage');
    }

    public function editAction( Request $request)
    {
       $idProduct = $request->get('idProduct');
       $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
       $product = $repositoryProduct->findOneByIdProduct($idProduct);

       if(!$product){
           throw $this->createNotFoundException(
               'No product found for id '.$idProduct
           );
       }

        $repositoryProductCategory = $this->getDoctrine()->getRepository(ProductCategory::class);
        $categories = $repositoryProductCategory->findAll();

        if($request->isMethod("POST")){
            try{
                $name = $request->get("name");
                $description = $request->get("description");
                $price = $request->get("price");
                $idProductCategory = $request->get("id_product_category");

                $objectCategory = $this->getDoctrine()->getRepository(ProductCategory::class)->find($idProductCategory);

                $product->setName($name);
                $product->setDescription($description);
                $product->setPrice($price);
                $product->setIdProductCategory($objectCategory);

                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                $this->addFlash(
                    'success',
                   'OPERATION_DONE'
                );
                return $this->redirectToRoute('backend_product_homepage');
            }catch (\Exception $e){
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );
            }
        }
        return $this->render('BackendProductBundle:Default:edit.html.twig' , array(
            'categories' => $categories ,
            'product' => $product
        ));
    }

    public function addAction(Request $request)
    {

        $repositoryProductCategory = $this->getDoctrine()->getRepository(ProductCategory::class);
        $categories = $repositoryProductCategory->findAll();

        if($request->isMethod("POST")){
            try{
                $name = $request->get("name");
                $description = $request->get("description");
                $price = $request->get("price");
                $idProductCategory = $request->get("id_product_category");

                if(trim($name)=="" || trim($description)=="" || trim($price)=="" || trim($idProductCategory)==""){
                    throw new \Exception("Champ obligatoire") ;
                }

                $em = $this->getDoctrine()->getManager();


                $product = new Product();
                $product->setName($name);
                $product->setPrice($price);
                $product->setDescription($description);

                $productCategory = $repositoryProductCategory->findOneByIdProductCategory($idProductCategory);

                $product->setIdProductCategory($productCategory);

                // tells Doctrine you want to (eventually) save the Product (no queries yet)
                $em->persist($product);

                // actually executes the queries (i.e. the INSERT query)
                $em->flush();

                $this->addFlash(
                    'success',
                    $this->get('translator')->trans('OPERATION_DONE')
                );

              // return $this->redirect("/backend/product");
               return $this->redirectToRoute('backend_product_homepage');
            }catch (\Exception $e){
                $this->addFlash(
                    'error',
                    $this->get('translator')->trans($e->getMessage())
                );
            }
        }
        return $this->render('BackendProductBundle:Default:add.html.twig' , array(
            'categories' => $categories
        ));
    }
}
