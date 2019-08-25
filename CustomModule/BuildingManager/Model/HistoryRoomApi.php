<?php
/**
 * cms-nckh - HistoryRoomApi.php
 *
 * Initial version by: linhphung
 * Initial version create on : 15/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model;

use CustomModule\BuildingManager\Api\Data\HistoryRoomInterface;
use  CustomModule\BuildingManager\Api\HistoryRoomManagementInterface;
use CustomModule\BuildingManager\Model\ResourceModel\HistoryRoom\CollectionFactory;
use CustomModule\BuildingManager\Model\HistoryRoomFactory;
use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;

class HistoryRoomApi implements HistoryRoomManagementInterface
{
    protected $_collectionFactory;
    protected $tokenModelFactory;
    protected $historyRoomFactory;

    /**
     * HistoryRoomApi constructor.
     * @param CollectionFactory $collectionFactory
     * @param TokenModelFactory $tokenModelFactory
     * @param \CustomModule\BuildingManager\Model\HistoryRoomFactory $historyRoomFactory
     */
    public function __construct(CollectionFactory $collectionFactory,
                                TokenModelFactory $tokenModelFactory,
                                HistoryRoomFactory $historyRoomFactory)
    {
        $this->_collectionFactory = $collectionFactory;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->historyRoomFactory = $historyRoomFactory;

    }

    /**
     * @param string $roomId
     * @return mixed
     */
    public function getByRoomId($roomId)
    {
        $result = array(
            "success" => false,
            "data" => ""
        );
        $data = $this->_collectionFactory->create()->addFieldToFilter('roomId', $roomId);
        $data = $data->getData();
        if ($data) {
            $result["success"] = true;
            $result["data"] = $data;
        }
        return json_encode($result, true);
        // TODO: Implement getByRoomId() method.
    }


    /**
     * @param string $roomId
     * @param string $dateCreate
     * @param string $token
     * @param string $content
     * @return mixed
     */
    public function saveData($roomId, $dateCreate, $token, $content)
    {
        $data = array(
            "datecreate" => $dateCreate,
            "roomID" => $roomId,
            "token" => $token,
            "content" => $content
        );
        $result = array(
            "success" => false,
            "data" => ""
        );

        $token = $this->tokenModelFactory->create()->loadByToken($token)->getData();
        if ($token) {
            $userId = $token['customer_id'];
            unset($data["token"]);
            $data["userID"] = $userId;
            $model = $this->saveDataHistoryRoom($data);
            if ($model){
                $result["data"] = array(
                    "message" => "Add History room unsuccessful."//$model//
                );
            }else{
                $result["success"] = true;
                $result["data"] = array(
                    "message" => "Add History room successfully."
                );
            }

        } else {
            $result["data"] = array(
                "message" => "You must to login."
            );
        }
        // TODO: Implement saveData() method.
        return json_encode($result, true);
    }


    public function saveDataHistoryRoom($data)
    {
        try {
           $model = $this->historyRoomFactory->create()->setData($data);
           $model->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}