<?php
/**
 * cms-nckh - ProjectApi.php
 *
 * Initial version by: linhphung
 * Initial version create on : 13/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model;

use CustomModule\BuildingManager\Api\ProjectManagementInterface;
use CustomModule\BuildingManager\Model\ResourceModel\Project\CollectionFactory;

class ProjectApi implements ProjectManagementInterface
{
    protected $_collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->_collectionFactory = $collectionFactory;
    }


    /**
     * @return mixed
     */
    public function view()
    {
        $result = array(
            "success" => false,
            "data" => ""
        );

        $data = $this->_collectionFactory->create()->getData();
        if ($data) {
            $result["success"] = true;
            $result["data"] = $data;
        }
        return json_encode($result, true);
        // TODO: Implement view() method.
    }
}