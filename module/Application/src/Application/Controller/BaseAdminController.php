<?php
namespace Application\Controller;


class BaseAdminController extends BaseController
{
    public function OnDispatch(\Zend\Mvc\MvcEvent $event)
    {
        /**
         * Проверка зарегестрирован пользователь или нет(для отображения админки)
         */
        if(!$this->identity()){
            return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
        }
        return parent::OnDispatch($event);

    }

}