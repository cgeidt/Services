<?php
namespace Registry\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use \Registry\Model\Service;

class ServiceController extends AbstractRestfulController
{
    public function getList()
    {
        /** @var \Registry\Model\ServiceTable $serviceTable */
        $serviceTable = $this->getServiceLocator()->get('Registry/Model/ServiceTable');
        $services = $serviceTable->fetchAll();
        /** @var \Registry\Model\Service $service */
        $serviceArr = array();
        foreach ($services as $service) {
            $serviceParsed = array();
            $serviceParsed['id'] = $service->getId();
            $serviceParsed['name'] = $service->getName();
            $serviceArr[] = $serviceParsed;
        }
        return new JsonModel(array(
            'success' => true,
            'data' => $serviceArr,
            'message' => ''
        ));
    }

    public function get($id)
    {
        /** @var \Registry\Model\ServiceTable $serviceTable */
        $serviceTable = $this->getServiceLocator()->get('Registry/Model/ServiceTable');
        /** @var \Registry\Model\Service $service */
            $service = $serviceTable->getService($id);

        if ($service) {
            $success = true;
            $data = array($service->getArrayCopy());
            $message = '';
        } else {
            $success = false;
            $data = array();
            $message = 'No service with id ' . $id . 'found';
        }

        return new JsonModel(array(
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ));

    }

    public function create($data)
    {
        /** @var \Registry\Model\Service $service */
        $service = new Service();

        $inputFilter = Service::getInputFilter();
        $inputFilter->setData($data);
        if($inputFilter->isValid()){
            $service->exchangeArray($inputFilter->getValues());
            /** @var \Registry\Model\ServiceTable $serviceTable */
            $serviceTable = $this->getServiceLocator()->get('Registry\Model\ServiceTable');
            try {
                $id = $serviceTable->saveService($service);

                $success = true;
                $data = array(
                    'id' => $id
                );
                $message = '';
            }catch(\Exception $e){
                $success = false;
                $data = array();
                $message = $e->getMessage();
            }

        }else{
            $success = false;
            $data = array();
            $message = $inputFilter->getMessages();
        }


        return new JsonModel(array(
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ));
    }

    public function update($id, $data)
    {
        /** @var \Registry\Model\Service $service */
        $service = new Service();
        $inputFilter = Service::getInputFilter();
        $inputFilter->setData($data);
        if($inputFilter->isValid()) {
            $service->exchangeArray($data);
            $service->setId($id);
            /** @var \Registry\Model\ServiceTable $serviceTable */
            $serviceTable = $this->getServiceLocator()->get('Registry\Model\ServiceTable');
            try {
                $id = $serviceTable->saveService($service);

                $success = true;
                $data = array(
                    'id' => $id,
                );
                $message = '';
            } catch (\Exception $e) {
                $success = false;
                $data = array();
                $message = $e->getMessage();
            }
        }else{
            $success = false;
            $data = array();
            $message = $inputFilter->getMessages();
        }

        return new JsonModel(array(
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ));;
    }

    public function delete($id)
    {
        /** @var \Registry\Model\ServiceTable $serviceTable */
        $serviceTable = $this->getServiceLocator()->get('Registry\Model\ServiceTable');
            $serviceTable->deleteService($id);
        return new JsonModel(array(
            'success' => true,
            'data' => array(
                'id' => $id,
            ),
            'message' => '',
        ));;
    }
}