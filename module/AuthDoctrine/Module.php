<?php
namespace AuthDoctrine;

use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\ServiceManager\ServiceManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                /**
                 * Сервис аутентефикации пользователя
                 */
                'Zend\Authentication\AuthenticationService' => function($serviceManage){
                    return $serviceManage->get('doctrine.authenticationservice.orm_default');
                },

                /**
                 * Сервис отправки писем
                 */
                'mail.transport' => function(ServiceManager $serviceManager){
                    $config = $serviceManager->get('Config');
                    $transport = new Smtp();
                    $transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));

                    return $transport;
                },
            ),
        );
    }
}
