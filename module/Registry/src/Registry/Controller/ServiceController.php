<?php
namespace Registry\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use \Registry\Model\Service;

class ServiceController extends AbstractRestfulController
{
    public function getList()
    {
        $description = $this->params()->fromQuery('description');
        $category = $this->params()->fromQuery('category');



        /** @var \Registry\Model\ServiceTable $serviceTable */
        $serviceTable = $this->getServiceLocator()->get('Services/Model/ServiceTable');
        $services = $serviceTable->fetchAll();
        /** @var \Registry\Model\Service $service */
        $serviceArr = array();
        foreach ($services as $service) {

            if ($this->passesFilterDescription($description,  $service->getDescription()) & $this->passesFilterCategory($category, $service->getCategories())) {
                $serviceParsed = array();
                $serviceParsed['id'] = $service->getId();
                $serviceParsed['name'] = $service->getName();
                $serviceParsed['description'] = $service->getDescription();
                $serviceParsed['categories'] = $service->getCategories();
                $serviceArr[] = $serviceParsed;
            }else{}
        }
        return new JsonModel(array(
            'success' => true,
            'data' => $serviceArr,
            'message' => ''
        ));
    }


    private function passesFilterDescription($descriptionFilter, $description){
        if($descriptionFilter == null || empty($descriptionFilter)){
            return true;
        }
        if(strpos($description, trim($descriptionFilter)) !== false){
            return true;
        }else{
            return false;
        }
    }

    private function passesFilterCategory($categoryFilter, $category){
        if($categoryFilter == null || empty($category)){
            return true;
        }
        $return = false;
        $catArr = explode(',',$category);
        foreach($catArr as $cat){
            if(trim($cat) == trim($categoryFilter)){
                $return = true;
                break;
            }
        }
        return $return;
    }

    public function get($id)
    {
        /** @var \Registry\Model\ServiceTable $serviceTable */
        $serviceTable = $this->getServiceLocator()->get('Services/Model/ServiceTable');
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
            $serviceTable = $this->getServiceLocator()->get('Services\Model\ServiceTable');
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
            $serviceTable = $this->getServiceLocator()->get('Services\Model\ServiceTable');
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
        ));
    }

    public function delete($id)
    {
        /** @var \Registry\Model\ServiceTable $serviceTable */
        $serviceTable = $this->getServiceLocator()->get('Services\Model\ServiceTable');
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