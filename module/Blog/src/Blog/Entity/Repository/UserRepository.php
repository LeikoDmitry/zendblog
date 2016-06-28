<?php

namespace Blog\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Blog\Entity\User;

/**
 * Class UserRepository
 *
 * Обработка полученыых от пользователя имени и пароля
 * @package Blog\Entity\Repository
 */
class UserRepository extends EntityRepository
{
    public function login(User $user, $serviceLocator)
    {
        $authservice = $serviceLocator->get('Zend\Authentication\AuthenticationService');
        $adapter = $authservice->getAdapter();
        $adapter->setIdentity($user->getUserName());
        $adapter->setCredential($user->getUserPassword());
        $authresult = $authservice->authenticate();

        $identity = null;

        if($authresult->isValid()){
            $identity = $authresult->getIdentity();
            $authservice->getStorage()->write($identity);
        }

        return $authresult;

    }

}