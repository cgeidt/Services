<?php
namespace Client\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Request;
use Zend\Http\Client;


class UserController extends AbstractActionController
{

    protected function getRegistryUrl()
    {
        $config = $this->getServiceLocator()->get('Config');
        return $config['registry_url'];
    }

    public function indexAction()
    {
        $description = $this->params()->fromQuery('description');
        $category = $this->params()->fromQuery('category');

        $client = new Client();
        $client->setUri($this->getRegistryUrl());
        $client->setMethod(Request::METHOD_GET);
        $client->setParameterGet(
            array(
                'description' => $description,
                'category' => $category,
            )
        );
        $response = $client->send();
        $result = json_decode($response->getBody());

        return array(
            'description' => $description,
            'category' => $category,
            'success' => $result->success,
            'message' => $result->message,
            'services' => $result->data
        );

    }

    public function detailAction()
    {
        $id = $this->params()->fromRoute('id');
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        ));
        $request->setUri($this->getRegistryUrl() . '/' . $id);
        $request->setMethod(Request::METHOD_GET);
        $client = new Client();
        $response = $client->dispatch($request);
        $result = json_decode($response->getBody());

        return array('success' => $result->success, 'message' => $result->message, 'service' => $result->data);
    }
}