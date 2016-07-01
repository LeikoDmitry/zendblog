<?php
namespace Admin;
use Admin\Service\IsExistsValidator;

/**
 * Class Module
 * Класс, отвечающий за конфигурацию модуля Admin
 * @package Admin
 */
class Module
{
    /**
     * Метод подгружает все настройки модуля
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Метод, отвечающий за исходные файлы модуля
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Регистрация сервисов
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Admin\Service\IsExistsValidator' => function($servicelocator){
                    $entityManager = $servicelocator->get('Doctrine\ORM\EntityManager');
                    $repository = $entityManager->getRepository('Blog\Entity\User');
                    return new IsExistsValidator($repository);
                }
            ),
        );
    }

}