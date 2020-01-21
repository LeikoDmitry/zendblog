<?php

namespace Admin\Form;

use Zend\Form\Form;


class CategoryAddForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct("CategoryAddForm");
        $this->setAttribute('method','post');
        $this->setAttribute('class', 'bs-example form-horizontal');

        $this->add(array(
            'name' => 'categoryKey',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Ключ',
            ),

            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name' => 'categoryName',
            'type' => 'Text',
            'options' => array(
                'min' => 3,
                'max' => 100,
                'label' => 'Название',
            ),

            'attributes' => array(
                'class' => 'form-control',
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => array(
                'value' => 'Сохранить',
                'class' => 'btn btn-primary',
                'id' => 'btn-submit',
            ),
        ));
    }
}