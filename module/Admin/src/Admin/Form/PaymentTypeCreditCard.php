<?php   

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use Zend\Form\Form;


class PaymentTypeCreditCard extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('PaymentTypeCreditCard');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(
            'type' => 'checkbox',
            'name' => 'visible',
            'attributes' => array(
                'class' => 'checkbox',
            ),
            'options' => array(
                'label' => 'Visible',
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ),
        ));
 
        $this->add(array( 
            'name' => 'deadline', 
            'type' => 'Zend\Form\Element\DateTime', 
            'attributes' => array( 
                'placeholder' => 'Deadline...', 
                'required' => 'required',
                'class' => 'form-control form-element datetimepicker',
            ), 
            'options' => array( 
                'label' => 'Deadline', 
            ), 
        ));
        $this->get('deadline')->setFormat('Y-m-d H:i:s');
 
        $this->add(array( 
            'name' => 'csrf', 
            'type' => 'Zend\Form\Element\Csrf', 
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}