<?php

namespace Mailman\Model\Login;

use Zend\Form\Form as Zend_Form;
use Zend\Form\Element;

class Form extends Zend_Form
{
    public function __construct($name = null)
    {
        parent::__construct('Login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        $this->initFields();
    }
    
    protected function initFields()
    {
        //username
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Username',
            ),
            'attributes' => array(
                'required' => 'required'
            ),
            'filters' => array(
                array('name' => 'StringTrim'),
            )
        ));
        
        //Password
        $password = new Element\Password('password');
        $password->setLabel('Password')
                 ->setAttributes(array(
                    'required'  => 'required',
            )
        );
        
        $this->add($password);
        
        //Submit Button
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'Submit',
                'value' => 'Submit',
                'class' => 'account-submit'
            ),
        ));
    }
}
