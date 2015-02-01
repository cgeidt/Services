<?php
namespace Services\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class ServiceController extends AbstractActionController {

    public function serviceAction() {
        $params = json_decode($this->params()->fromPost('parameters'), true);
        $success = true;
        $result = '';
        $message = '';

        $name = $this->params()->fromRoute('servicename');
        $path = '\Services\Model\\'.$name;
        $command  = $this->params()->fromRoute('command');
        /** @var \Services\Model\Service $service */
        $service = new $path();

        try {
            $result = $service->$command($params);
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return new JsonModel(array(
            'success' => $success,
            'data' => $result,
            'message' => $message,
        ));
    }

}