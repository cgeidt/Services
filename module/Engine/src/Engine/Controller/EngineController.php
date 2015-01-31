<?php
namespace Engine\Controller;

use Registry\Model\Service;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class EngineController extends AbstractActionController {

    protected function getRegistryUrl(){
        $config = $this->getServiceLocator()->get('Config');
        return $config['registry_url'];
    }

    private function getServiceInfo($id) {
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        ));
        $request->setUri($this->getRegistryUrl(). '/'. $id);
        $request->setMethod(Request::METHOD_GET);
        $client = new Client();
        $response = $client->dispatch($request);
        $result = json_decode($response->getBody());
        return $result->data[0];
    }

    private function getServiceMetadata($url) {
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        ));
        $request->setUri($url.'/'.\Services\Model\Service::META);
        $request->setMethod(Request::METHOD_GET);
        $client = new Client();
        $response = $client->dispatch($request);
        $result = json_decode($response->getBody());
        return $result->data[0];
    }

    private function executeService($url, $parameters) {
        $client = new Client();
        $client->setUri($url.'/'.\Services\Model\Service::EXEC);
        $client->setMethod(Request::METHOD_POST);
        $client->setParameterPost(array('parameters'=> $parameters));
        $response = $client->send();
        $result = $response->getBody();
        return $result;
    }

    private function executeComposedService($composition, $parameters) {
        var_dump($composition);
        var_dump($parameters);
        exit;

        // for each service in composition -> execute service

    }

    public function executeAction() {
        // parameters: $id, $parameters
        $id = $this->params()->fromPost('id');
        $parameters = $this->params()->fromPost('parameters');

        // get service information from registry
        $serviceinfo = $this->getServiceInfo($id);

        // check if service is composed and execute it
        $result = null;
        if ($serviceinfo->composition == null) {
            // single service
            $result = $this->executeService($serviceinfo->url, $parameters);
        } else {
            // composed service
            $result = $this->executeComposedService($serviceinfo->composition, $parameters);
        }

        return $result;
    }

}