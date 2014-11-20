<?php
namespace Service\Model;

/**
 * Created by PhpStorm.
 * User: cgeidt
 * Date: 17.11.2014
 * Time: 15:36
 */

use Zend\InputFilter\InputFilter;


class Service {

    protected $id;
    protected $name;
    protected $description;
    protected $url;

    public function exchangeArray($data = array()){
        $this->id  = empty($data['id']) ? null : $data['id'];
        $this->name  = empty($data['name']) ? null : $data['name'];
        $this->description  = empty($data['description']) ? null : $data['description'];
        $this->url  = empty($data['url']) ? null : $data['url'];
    }

    public function getArrayCopy(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
        );
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


    /**
     * @return InputFilter $filter
     */
    public static function getInputFilter(){

        $filter = new InputFilter();

        $filter->add(array(
            'name' => 'name',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'not_empty',
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1,
                        'max' => 255,
                    ),
                ),
            ),
        ));

        $filter->add(array(
            'name' => 'description',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'not_empty',
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1,
                    ),
                ),
            ),
        ));

        $filter->add(array(
            'name' => 'url',
            'validators' => array(
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1,
                    ),
                ),
            ),
        ));

        return $filter;
    }



} 