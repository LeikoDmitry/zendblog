<?php

namespace AuthDoctrine\Controller;


use Application\Controller\BaseController;
use Blog\Entity\User;
use Zend\Authentication\Result;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $entityManager = $this->getEntityManager();
        $users = $entityManager->getRepository('Blog\Entity\User')->findAll();
        return array('users' => $users);
    }

    public function loginAction()
    {
        $entiyManager = $this->getEntityManager();
        $user = new User();
        $form = getLoginForm($user);

        $message = null;
        $request = $this->getRequest();

        if($request->isPost()){
            $form->setData($request->getPost());
           if($form->isValid()){
               $user = $form->getData();
               $authresult = $entiyManager->getRepository('Blog\Entity\User')->login($user, $this->getServiceLocator());
               if($authresult->getCode != Result::SUCCESS){
                   foreach ($authresult->getMessage as $value){
                       $message .= $value;
                   }
               }
           }else{
               return array();
           }
        }

        return array('form' => $form, 'message' => $message);
    }

}