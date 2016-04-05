<?php
namespace Application\Controller;


class BaseAdminController extends BaseController
{
    public function OnDispatch(\Zend\Mvc\MvcEvent $event)
    {


        return parent::OnDispatch($event);

    }

}