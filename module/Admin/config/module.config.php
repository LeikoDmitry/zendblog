<?php
return array(
     // Конфигурация для RouteManager
    // Объявляем какие есть контроллеры
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'category'               => 'Admin\Controller\CategoryController',
            'article'                => 'Admin\Controller\ArticleController',
        ),
    ),

    // Маршруты
    'router' => array(
        // Конфигурация для всех возможных маршрутов
        'routes' => array(
            // Новый маршрут "admin"
            'admin' => array(
                // Тип маршрута
                'type' => 'literal',
                // Конфигурация для маршрута
                'options' => array(
                    // Какому URL принадлежит маршрут
                    'route'    => '/admin/',
                    // Действия по умолчанию
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,

                'child_routes' => array(
                    'category' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'category/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'category',
                                'action'     => 'index',
                            ),
                        ),
                    ),

                    'article' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'article/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'article',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),//end child_routes

            ),

        ),
    ),

    // Навигации сайта
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Главная',
                'route' => 'home',
            ),
        ),

        'admin' => array(
            array(
                'label' => 'Панель управления сайтом',
                'route' => 'admin',
                'action'=> 'index',
                'pages' => array(
                    array(
                        'label' => 'Статьи',
                        'route' => 'admin/article',
                        'action' => 'index',
                    ),
                    array(
                        'label' => 'Добавление статьи',
                        'route' => 'admin/article',
                        'action' => 'add',
                    ),

                    array(
                        'label' => 'Категории',
                        'route' => 'admin/category',
                        'action' => 'index',
                    ),
                    array(
                        'label' => 'Добавление категории',
                        'route' => 'admin/category',
                        'action' => 'add',
                    ),
                ),
            ),

        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Navigation\Service\NavigationAbstractServiceFactory'
        ),
    ),
    // Виды
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),

        'template_map' => array(
            'pagination_control' => __DIR__ . '/../view/layout/pagination_control.phtml',
        ),
    ),

    'module_layouts' => array(
       'Admin' => '/layout/admin-layout',
    ),

);