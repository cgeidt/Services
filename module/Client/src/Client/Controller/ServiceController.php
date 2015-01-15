<?php
namespace Client\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Request;
use Zend\Http\Client;


class ServiceController extends AbstractActionController
{

    protected function getRegistryUrl(){
        $config = $this->getServiceLocator()->get('Config');
        return $config['registry_url'];
    }

    public function indexAction()
    {
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        ));
    $request->setUri($this->getRegistryUrl());
    $request->setMethod(Request::METHOD_GET);
    $client = new Client();
    $response = $client->dispatch($request);
    $result = json_decode($response->getBody());

    return array('success' => $result->success, 'services' => $result->data);
   }
}