<?php

namespace Backend\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder ;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use AppBundle\Entity\User ;

class DefaultController extends Controller
{

    public function indexAction()
    {

        $repository = $this->getDoctrine()->getRepository(User::class);

        $query = $repository->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.fullname', 'ASC')
            ->getQuery();

        $users = $query->getResult();


        return $this->render('BackendUserBundle:Default:index.html.twig' , array(
            'users' => $users
        ));
    }

    public function deleteAction(Request $request)
    {
        $idUser = $request->get('idUser');
        try{

            $conn = $this->getDoctrine()->getConnection();
            $queryBuilder = $conn->createQueryBuilder();
            $queryBuilder->delete('user')
            ->where('id_user = :idUser')
            ->setParameter('idUser', $idUser);
            $queryBuilder->execute();

            $photoFilePath = $this->get('kernel')->getRootDir() . '/../web/img/users/'.$idUser.'jpg';
            if(file_exists($photoFilePath)){
                unlink($photoFilePath);
            }

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
        return $this->redirectToRoute('backend_user_homepage');
    }

    public function editAction( Request $request)
    {
        $idUser = $request->get('idUser');

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('u')
            ->from('AppBundle\Entity\User', 'u')
            ->where('u.idUser = :idUser')
            ->setParameter('idUser', $idUser);

        $query = $query->getQuery();

        try{
            $user = $query->getSingleResult();

        }catch (\Doctrine\ORM\NoResultException $e){
            throw $this->createNotFoundException(
                'No user found for id '.$idUser
            );
        }


       /* $result = $query->getResult();
        $single = $query->getSingleResult();
        $array = $query->getArrayResult();
        $scalar = $query->getScalarResult();
        $singleScalar = $query->getSingleScalarResult();*/


        if($request->isMethod("POST")){
            try{

                $conn = $this->getDoctrine()->getConnection();
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder
                    ->update('user', 'u')
                    ->set('u.fullname' ,':fullname')
                    ->set('u.email', ':email' )
                    ->set('u.password', ':pwd')
                    ->set('u.role', ':role')
                    ->where($queryBuilder->expr()->eq('u.id_user', ':userId'))
                    ->setParameters(
                        array(
                            'fullname' => $request->get("fullname"),
                            'email' => $request->get("email"),
                            'pwd' => $request->get("password") ,
                            'role' => $request->get("role") ,
                            'userId' => $idUser
                        )
                    );

                $queryBuilder->execute();

                if($request->files->get('photo')){
                    $file = $request->files->get('photo');
                    $fileName = $idUser.'.jpg';
                    $path = $this->get('kernel')->getRootDir() . '/../web/img/users/';
                    $file->move($path, $fileName);
                }

                $this->addFlash(
                    'success',
                    $this->get('translator')->trans('OPERATION_DONE')
                );
                return $this->redirectToRoute('backend_user_homepage');

            }catch (\Exception $e){
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );
            }
        }
        return $this->render('BackendUserBundle:Default:edit.html.twig' , array(
            'user' => $user
        ));
    }

    public function addAction(Request $request)
    {
        if($request->isMethod("POST")){
            try{
                $fullname = $request->get("fullname");
                $email = $request->get("email");
                $password = $request->get("password");
                $role = $request->get("role");

                if(trim($fullname)=="" || trim($email)=="" || trim($password)=="" || trim($role)==""){
                    throw new \Exception("Champ obligatoire") ;
                }

                $encryptedPassword = $password ;
                //$user = new \AppBundle\Entity\User();
                //$encryptedPassword = $encoder->encodePassword($user, $password);

                $conn = $this->getDoctrine()->getConnection();
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder->insert('user')
                    ->values (  array(
                        'fullname' => '?' ,
                        'email' => '?' ,
                        'password' => '?',
                        'role' => '?'
                     ));
                $queryBuilder->setParameters( array($fullname,$email,$encryptedPassword,$role));
                $queryBuilder->execute();
                $idUser = $conn->lastInsertId();

                if($request->files->get('photo')){
                    $file = $request->files->get('photo');
                    $fileName = $idUser.'.jpg';
                    $path = $this->get('kernel')->getRootDir() . '/../web/img/users/';
                    $file->move($path, $fileName);
                }


                $this->addFlash(
                    'success',
                    $this->get('translator')->trans('OPERATION_DONE')
                );

                return $this->redirectToRoute('backend_user_homepage');
            }catch (\Exception $e){
                $this->addFlash(
                    'error',
                    $e->getMessage()
                );
            }
        }
        return $this->render('BackendUserBundle:Default:add.html.twig' , array(
        ));
    }
}
