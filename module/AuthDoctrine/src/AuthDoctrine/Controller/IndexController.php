<?php

namespace AuthDoctrine\Controller;

use Application\Controller\BaseController;
use Blog\Entity\User;
use Zend\Authentication\Result;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Zend\Mail\Message;
use Zend\Session\SessionManager;

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
     * Метод выхода пользователя
     *
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity();
        }

        $auth->clearIdentity();
        $sessionManager = new SessionManager();
        $sessionManager->forgetMe();
        return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
    }

    /**
     * Метод регистрации пользователей
     *
     *
     * @return array|\Zend\Http\Response
     */
    public function registerAction()
    {
        $entityManager = $this->getEntityManager();
        $user = new User();
        $form = $this->getRegForm($user);
        $request = $this->getRequest();

        if($request->isPost()){
            $form->setData($request->getPost());
            $apiService = $this->getServiceLocator()->get('Admin\Service\IsExistsValidator');
            if($form->isValid()){
                if($apiService->isExists($user->getUserName(), array('userName'))){
                    $this->flashMessenger()->addErrorMessage('Пользователь с таким именем уже существует!');
                    return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'register'));
                }
                $this->prepareDataUser($user);
                $this->sendConfirmationEmail($user);
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'registration-success'));
            }
        }


        return array('form' => $form);
    }

    /**
     * Потверждение регистрации
     *
     * @return \Zend\Http\Response
     */
    public function registrationSuccessAction()
    {
        $this->flashMessenger()->addMessage('Вы успешно зарегестрированы, пожалуйста войдите!');
        return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
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
        $form->setAttribute('class', 'form-horizontal');

        return $form;
    }

    /**
     * Создание формы регистрации
     *
     * @param User $user
     * @return \Zend\Form\Form
     */
    public function getRegForm(User $user)
    {
        $form = $this->getUserForm($user);
        $form->setAttribute('action', '/auth-doctrine/index/register/');
        $form->setAttribute('class', 'form-horizontal');
        $form->setValidationGroup('userName', 'userPassword','userEmail', 'confimPasswor');
        $form->get('submit')->setAttribute('value', 'Зарегестрировать');

        return $form;

    }


    /**
     * Добавление нового пароля с шифрованием
     *
     *
     * @param User $user
     * @return User
     */
    public function prepareDataUser(User $user)
    {
        $user->setUserPasswordSalt(md5(time() . 'setUserPasswordSalt'));
        $user->setUserPassword(md5('staticSalt' . $user->getUserPassword() . $user->getUserPasswordSalt()));

        return $user;
    }

    /**
     * Отправка письма после регистрации пользователю
     *
     * @param User $user
     */
    public function sendConfirmationEmail(User $user)
    {
        $transport = $this->getServiceLocator()->get('mail.transport');
        $message = new Message();
        $message->setEncoding('UTF-8')
            ->addTo($user->getUserEmail())
            ->addFrom('leik.83@mail.ru')
            ->setSubject('Регистрация')
            ->setBody('Вы успешно зарестрированы на '. $this->getRequest()->getServer('HTTP_HOST'));

        $transport->send($message);

    }

}