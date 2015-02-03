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

    protected function getEngineUrl()
    {
        $config = $this->getServiceLocator()->get('Config');
        return $config['execution_engine_url'];
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

    public function executeAction() {
        $id = $this->params()->fromRoute('id');

        if($this->getRequest()->isPost()){

            $client = new Client();
            $client->setUri($this->getRegistryUrl().'/'.$id);
            $client->setMethod(Request::METHOD_GET);
            $response = $client->send();
            $resultService = json_decode($response->getBody());

            $params = $this->params()->fromPost('parameters');

            $client = new Client();
            $client->setUri($this->getEngineUrl());
            $client->setMethod(Request::METHOD_POST);
            $client->setParameterPost(
                array(
                    'id' => (int)$id,
                    'parameters' => json_encode($params),
                    )
            );
            $response = $client->send();
            $result = json_decode($response->getBody());

            return array('service' => $resultService->data[0], 'results' => $result->data, 'error' => $result->message, 'parameters' => $params);

        }else{
            $client = new Client();
            $client->setUri($this->getRegistryUrl().'/'.$id);
            $client->setMethod(Request::METHOD_GET);
            $response = $client->send();
            $result = json_decode($response->getBody());

            if($result->success){
                return array('service' => $result->data[0]);
            }else{
                return $this->redirect()->toRoute('client', array('controller' => 'user'));
            }
        }


    }


}