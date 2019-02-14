<?php
namespace AppBundle\Security\User;

use AppBundle\Security\User\WebserviceUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;


class WebserviceUserProvider implements UserProviderInterface
{
    /**
     * @var @var \Doctrine\ORM\EntityRepository
     */
    private $repository;


    public function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine )
    {
        $this->repository = $doctrine->getRepository(\AppBundle\Entity\User::class);
    }

    public function loadUserByUsername($username)
    {
        $userData = $this->repository->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $username)
            ->getQuery();
        $userData = $userData->getSingleResult();

        if ($userData) {
            $password = $userData->getPassword();
            $salt = null ;
            $roles = array($userData->getRole());

            return new WebserviceUser($username, $password, $salt, $roles);
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return WebserviceUser::class === $class;
    }
}