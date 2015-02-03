<?php
namespace Registry\Model;

use Zend\Db\TableGateway\TableGateway;

class ServiceTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getService($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        if($rowset->count() == 0){
            return null;
        }
        return $rowset->current();
    }

    public function saveService(Service $service)
    {
        $data = $service->getArrayCopy();

        $id = (int) $service->getId();
        if (!$id) {
            if($this->getService($id)){
                throw new \Exception('A service with the name "'.$service->getName().'" already exists');
            }
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            //avoid overwrite
            unset($data['createdAt']);
            if ($this->getService($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Service id does not exist');
            }
        }
        return $id;
    }

    public function deleteService($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}