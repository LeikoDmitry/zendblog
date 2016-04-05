<?php
return array(
     // Конфигурация для RouteManager

    // Doctrine
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'blog_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                   __DIR__ . "/../src/Blog/Entity"
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Blog\Entity' => 'blog_entity'
                ),
            ),
        ),
    ),

    // Объявляем какие есть контроллеры
    'controllers' => array(
        'invokables' => array(
            'Blog\Controller\Index' => 'Blog\Controller\IndexController',
        ),
    ),

    // Маршруты
    'router' => array(
        // Конфигурация для всех возможных маршрутов
        'routes' => array(
            // Новый маршрут "blog"
            'blog' => array(
                // Тип маршрута
                'type' => 'segment',
                // Конфигурация для маршрута
                'options' => array(
                    // Какому URL принадлежит маршрут
                    'route'    => '/[:action/][:id/]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        ),
                    // Действия по умолчанию
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    // Виды
    'view_manager' => array(
        'template_path_stack' => array(
            'blog' => __DIR__ . '/../view',
        ),
    ),
);