<?php
/**
 * cms-nckh - Room.php
 *
 * Initial version by: linhphung
 * Initial version create on : 05/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Room extends AbstractDb
{

    public function _construct()
    {
        $this->_init('custom_module_room', 'id');
    }

}