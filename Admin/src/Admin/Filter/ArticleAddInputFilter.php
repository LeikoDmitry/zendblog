<?php
namespace Admin\Filter;

use Zend\InputFilter\InputFilter;


class ArticleAddInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'title',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 100,
                    ),
                ),
            ),
            'filters' => array(
                array( 'name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name' => 'shortArticle',
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 800,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name' => 'article',
            'required' => true,

        ));

    }

}