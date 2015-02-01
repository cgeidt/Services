<?php
namespace Registry\Model;

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
    protected $composition;
    protected $input;
    protected $output;
    protected $categories;
    protected $createdAt;
    protected $editedAt;

    public function exchangeArray($data = array()){
        $this->id  = empty($data['id']) ? null : $data['id'];
        $this->name  = empty($data['name']) ? null : $data['name'];
        $this->description  = empty($data['description']) ? null : $data['description'];
        $this->url  = empty($data['url']) ? null : $data['url'];
        $this->composition = empty($data['composition']) ? null : $data['composition'];
        $this->input = empty($data['input']) ? null : $data['input'];
        $this->output = empty($data['output']) ? null : $data['output'];
        $this->categories = empty($data['categories']) ? null : $data['categories'];
        $this->createdAt = empty($data['createdAt']) ? null : $data['createdAt'];
        $this->editedAt = empty($data['editedAt']) ? null : $data['editedAt'];
    }

    public function getArrayCopy(){
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'composition' => $this->composition,
            'input' => $this->input,
            'output' => $this->output,
            'categories' => $this->categories,
            'createdAt' => $this->createdAt,
            'editedAt' => $this->editedAt,
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
     * @return mixed
     */
    public function getComposition()
    {
        return $this->composition;
    }

    /**
     * @param mixed $composition
     */
    public function setComposition($composition)
    {
        $this->composition = $composition;
    }

    /**
     * @return mixed
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param mixed $input
     */
    public function setInput($input)
    {
        $this->input = $input;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param mixed $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * @param mixed $editedAt
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;
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

        $filter->add(array(
            'name' => 'composition',
            'validators' => array(
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1,
                    ),
                ),
            ),
        ));

        $filter->add(array(
            'name' => 'input',
            'validators' => array(
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1,
                    ),
                ),
            ),
        ));

        $filter->add(array(
            'name' => 'output',
            'validators' => array(
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1,
                    ),
                ),
            ),
        ));

        $filter->add(array(
            'name' => 'categories',
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