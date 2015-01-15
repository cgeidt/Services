<?php
namespace Services\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class ServiceController extends AbstractActionController {
    public function serviceOneAction() {
        $params = json_decode($this->params()->fromPost('params'), true);
        $success = true;
        $result = '';
        $message = '';

        try {
            $result = \Services\Model\ServiceOne::execute($params);
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