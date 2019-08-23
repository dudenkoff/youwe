<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Class PostForm
 */
class PostForm extends Form
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('post-form');

        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * Add elements to form
     */
    protected function addElements()
    {
        $this->add([
            'type' => 'textarea',
            'name' => 'content',
            'attributes' => [
                'id' => 'content'
            ],
            'options' => [
                'label' => 'Content',
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Analyze',
                'id' => 'submitbutton',
            ],
        ]);
    }

    /**
     * Add input filter to form
     */
    private function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'content',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 255
                    ],
                ],
            ],
        ]);
    }
}
