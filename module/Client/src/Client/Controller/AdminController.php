<?php
namespace Client\Controller;

use Client\Form\ServiceForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Request;
use Zend\Http\Client;


class AdminController extends AbstractActionController
{

    protected function getRegistryUrl(){
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

    public function indexAdminAction()
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

        return array('success' => $result->success, 'message' => $result->message, 'services' => $result->data);
    }

    public function detailAction(){
        $id = $this->params()->fromRoute('id');
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        ));
        $request->setUri($this->getRegistryUrl(). '/'. $id);
        $request->setMethod(Request::METHOD_GET);
        $client = new Client();
        $response = $client->dispatch($request);
        $result = json_decode($response->getBody());
        return array('success' => $result->success, 'message' => $result->message, 'service' => $result->data);
    }

    public function addAction()
    {
        $form = new ServiceForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
                if($form->isValid()){
                    $serviceData = $form->getData();
                    $serviceData['composition'] = json_encode(explode(',', $serviceData['composition']));
                    $serviceData['input'] = json_encode(explode(',', $serviceData['input']));
                    $serviceData['output'] = json_encode(explode(',', $serviceData['output']));
                    $client = new Client();
                    $client->setUri($this->getRegistryUrl());
                    $client->setMethod(Request::METHOD_POST);
                    $client->setParameterPost($serviceData);
                    $response = $client->send();
                    $result = json_decode($response->getBody());
                    if($result->success){
                        return $this->redirect()->toRoute('client', array('controller' => 'admin'));
                    }else{
                        return array('form' => $form, 'errorMessage' => $result->message);
                    }
                }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('client', array('controller' => 'admin'));
        }
        $form  = new ServiceForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $serviceData = $form->getData();
                $serviceData['composition'] = json_encode(explode(',', $serviceData['composition']));
                $serviceData['input'] = json_encode(explode(',', $serviceData['input']));
                $serviceData['output'] = json_encode(explode(',', $serviceData['output']));

                $client = new Client();
                $client->setUri($this->getRegistryUrl().'/'.$id);
                $client->setParameterPost($serviceData);
                $client->setMethod(Request::METHOD_PUT);
                $response = $client->send();
                $result = json_decode($response->getBody());
                if($result->success){
                    return $this->redirect()->toRoute('client', array('controller' => 'admin'));
                }else{
                    return array('form' => $form, 'errorMessage' => $result->message);
                }
            }
        }else{

            $client = new Client();
            $client->setUri($this->getRegistryUrl().'/'.$id);
            $client->setMethod(Request::METHOD_GET);
            $response = $client->send();
            $result = json_decode($response->getBody(),true);

            if($result['success']){
                $form->setData($result['data'][0]);
                if($form->get('composition')->getValue()) {
                    $form->get('composition')->setValue(implode(',', json_decode($form->get('composition')->getValue())));
                }
                if($form->get('input')->getValue()){
                    $form->get('input')->setValue(implode(',', json_decode($form->get('input')->getValue())));
                }
                if($form->get('output')->getValue()){
                    $form->get('output')->setValue(implode(',', json_decode($form->get('output')->getValue())));
                }
                $form->get('submit')->setValue('Edit');
                return array('form' => $form);
            }else{
                return $this->redirect()->toRoute('client', array('controller' => 'admin'));
            }
        }
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('client', array('controller' => 'admin'));
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $client = new Client();
                $client->setUri($this->getRegistryUrl().'/'.$id);
                $client->setMethod(Request::METHOD_DELETE);
                $client->send();
            }
            return $this->redirect()->toRoute('client', array('controller' => 'admin'));
        }

        $client = new Client();
        $client->setUri($this->getRegistryUrl().'/'.$id);
        $client->setMethod(Request::METHOD_GET);
        $response = $client->send();
        $result = json_decode($response->getBody());
        if($result->success){
            return array('service' => $result->data[0]);
        }else{
            return $this->redirect()->toRoute('client', array('controller' => 'admin'));
        }


    }

}