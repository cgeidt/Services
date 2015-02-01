<?php
/**
 * Created by PhpStorm.
 * User: cgeidt
 * Date: 31.01.2015
 * Time: 12:05
 */
namespace Client\Form;

use Zend\Form\Form;

class ServiceForm extends Form{

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('serviceform');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'composition',
            'type' => 'Text',
            'attributes' => array(
                'class' => 'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'type' => 'Text',

            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'url',
            'type' => 'Text',

            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'input',
            'type' => 'Text',

            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'output',
            'type' => 'Text',

            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'categories',
            'type' => 'Text',

            'attributes' => array(
                'class' => 'form-control',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Create',
                'id' => 'submit',
                'class' => 'btn btn-success',
            ),
        ));
        $this->setAttribute('class','form-horizontal');

    }
}