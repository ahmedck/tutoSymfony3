<?php

namespace Backend\ProductCategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\ProductCategory ;


class DefaultController extends Controller
{
    public function indexAction()
    {

        $categories = $this->get('backend_product_category_service')->getAll();


        return $this->render('BackendProductCategoryBundle:Default:index.html.twig' , array(
            'categories' => $categories
        ));
    }



    public function deleteAction(Request $request)
    {
        $idCategory = $request->get('idProductCategory');
        try{
            $this->get('backend_product_category_service')->delete($idCategory);

            $this->addFlash(
                'success',
                $this->get('translator')->trans('OPERATION_DONE')
            );
        }catch(\Exception $e){
            $this->addFlash(
                'error',
                $e->getMessage()
            );
        }
        return $this->redirectToRoute('backend_product_category_homepage');
    }

    public function editAction( Request $request)
    {
        $idProductCategory = $request->get('idProductCategory');
        $repositoryCategory = $this->getDoctrine()->getRepository(ProductCategory::class);
        $category = $repositoryCategory->findOneByIdProductCategory($idProductCategory);

        if(!$category){
            throw $this->createNotFoundException(
                'No category found for id '.$idProductCategory
            );
        }

        if($request->isMethod("POST")){
            try{

                $category->setCategory($request->get('category'));

                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();

                $this->addFlash(
                    'success',
                    $this->get('translator')->trans('OPERATION_DONE')
                );
                return $this->redirectToRoute('backend_product_category_homepage');

            }catch (\Exception $e){
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );
            }
        }

        return $this->render('BackendProductCategoryBundle:Default:edit.html.twig' , array(
            'category' => $category
        ));
    }

    public function addAction(Request $request)
    {

        if($request->isMethod("POST")){
            try{

                if(trim($request->get("category"))=="" ){
                    throw new \Exception("Champ obligatoire") ;
                }

                $category = new ProductCategory();
                $category->setCategory($request->get("category"));

                $em = $this->getDoctrine()->getManager();
                // tells Doctrine you want to (eventually) save the Product (no queries yet)
                $em->persist($category);
                // actually executes the queries (i.e. the INSERT query)
                $em->flush();

                $this->addFlash(
                    'success',
                    $this->get('translator')->trans('OPERATION_DONE')
                );

                // return $this->redirect("/backend/product");
                return $this->redirectToRoute('backend_product_category_homepage');
            }catch (\Exception $e){
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );
            }
        }
        return $this->render('BackendProductCategoryBundle:Default:add.html.twig' , array(
        ));
    }


}
