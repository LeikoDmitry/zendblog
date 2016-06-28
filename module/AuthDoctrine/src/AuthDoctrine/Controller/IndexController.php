<?php

namespace AuthDoctrine\Controller;

use Application\Controller\BaseController;
use Blog\Entity\User;
use Zend\Authentication\Result;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

class IndexController extends BaseController
{
    /**
     * Вывод всех пользователей
     *
     * @return array
     */
    public function indexAction()
    {
        $entityManager = $this->getEntityManager();
        $users = $entityManager->getRepository('Blog\Entity\User')->findAll();
        return array('users' => $users);
    }

    /**
     * Страница входа пользователя
     *
     *
     * @return array
     */
    public function loginAction()
    {
        $entiyManager = $this->getEntityManager();
        $user = new User();
        $form = $this->getLoginForm($user);

        $message = null;
        $request = $this->getRequest();

        if($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $form->getData();
                $authresult = $entiyManager->getRepository('Blog\Entity\User')->login($user, $this->getServiceLocator());
                if ($authresult->getCode() != Result::SUCCESS) {
                    foreach ($authresult->getMessages() as $value) {
                        $message .= $value . "\n";
                    }
                }else{
                    return array();
                }
            }
        }
        return array('form' => $form, 'messages' => $message);

    }

    /**
     * Создание формы из анотаций объекта
     *
     * @param User $user
     * @return \Zend\Form\Form
     */
    public function getUserForm(User $user)
    {
        $biulder = new AnnotationBuilder($this->getEntityManager());
        $form = $biulder->createForm('\Blog\Entity\User');
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager()), 'User');
        $form->bind($user);

        return $form;
    }

    /**
     * Получение формы
     *
     * @param User $user
     * @return \Zend\Form\Form
     */
    public function getLoginForm(User $user)
    {
        $form = $this->getUserForm($user);
        $form->setAttribute('action', '/auth-doctrine/index/login/');
        $form->setValidationGroup('userName', 'userPassword');

        return $form;
    }

}