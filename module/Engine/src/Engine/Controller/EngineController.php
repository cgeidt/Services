<?php
namespace Engine\Controller;

use Registry\Model\Service;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class EngineController extends AbstractActionController {

    private $message;

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
        $comp = json_decode($composition);
        $params = $parameters;
        $length = count($comp);

        $result = null;
        $serviceinfo = null;
        $url = null;

        // for each service in composition -> execute service
        for ($i = 0; $i < $length; $i++) {
            // get service id
            $id = $comp[$i];
            // get serviceinfo
            $serviceinfo = $this->getServiceInfo($id);
            // get url for service
            $url = $serviceinfo->url;
            // execute service
            $result = $this->executeService($url, $params);
            // show whats happening
            $msg = '<strong>'.$serviceinfo->name.':</strong>&nbsp;&nbsp;'.$serviceinfo->description.',&nbsp;&nbsp;parameters:&nbsp;'.$params.',&nbsp;&nbsp;result:&nbsp;'.json_encode(json_decode($result)->data);
            $this->addMessage($msg.PHP_EOL);
            // set params for next service
            $params = json_encode(json_decode($result)->data);
        }

        return $result;
    }

    public function executeAction() {
        // parameters: $id, $parameters
        $id = $this->params()->fromPost('id');
        $parameters = $this->params()->fromPost('parameters');

        // reset message
        $this->setMessage('');

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

        $returnObject = json_decode($result, true);
        $returnObject['message'] = $this->getMessage();
        return new JsonModel($returnObject);
    }


    private function getMessage() {
        return $this->message;
    }

    private function setMessage($message) {
        $this->message = $message;
    }

    private function addMessage($message) {
        $this->message .= $message;
    }

}