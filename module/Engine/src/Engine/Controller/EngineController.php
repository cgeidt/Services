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

    public function executeAction() {
        // parameters: $id, $params
        $id = $this->params()->fromRoute('id');

        // get service information from registry
        $serviceinfo = $this->getServiceInfo($id);

        var_dump($serviceinfo);

        // check if service is composed
        if ($serviceinfo->composition == null) {
            // get metadata for service
            $metadata = $this->getServiceMetadata($serviceinfo->url);
            var_dump($metadata);
        }

        exit;


        // check if service is combined

        // call service with params

        // call combined service one by one with params

        // return result

    }

}