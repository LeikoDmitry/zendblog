<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;


class BaseController extends AbstractActionController
{
    protected $entityManager;
    public function OnDispatch(\Zend\Mvc\MvcEvent $event)
    {
        $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
        return parent::OnDispatch($event);

    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

}