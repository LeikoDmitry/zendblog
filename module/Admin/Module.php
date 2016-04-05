<?php
namespace Admin;

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

}