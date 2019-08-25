<?php
/**
 * cms-nckh - UserApi.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model;


use CustomModule\BuildingManager\Api\Data\UserInterface;
use CustomModule\BuildingManager\Api\UserManagementInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Integration\Model\CredentialsValidator;
use CustomModule\BuildingManager\Model\ResourceModel\User\CollectionFactory;
use CustomModule\BuildingManager\Model\ResourceModel\UserFactory;

use Magento\Integration\Model\Oauth\TokenFactory as TokenModelFactory;
use phpDocumentor\Reflection\Types\Object_;

class UserApi implements UserManagementInterface
{
    private $validatorHelper;
    private $_collectionFactory;
    /**
     * Token Model
     *
     * @var TokenModelFactory
     */
    private $tokenModelFactory;

    private $_resource;
    private $_userFactory;

    /**
     * UserApi constructor.
     * @param CredentialsValidator $validatorHelper
     * @param CollectionFactory $collectionFactory
     * @param TokenModelFactory $tokenModelFactory
     * @param ResourceConnection $resource
     * @param UserFactory $userFactory
     */
    public function __construct(CredentialsValidator $validatorHelper,
                                CollectionFactory $collectionFactory,
                                TokenModelFactory $tokenModelFactory,
                                ResourceConnection $resource,
                                UserFactory $userFactory)
    {
        $this->_collectionFactory = $collectionFactory;
        $this->validatorHelper = $validatorHelper;
        $this->tokenModelFactory = $tokenModelFactory;
        $this->_resource = $resource;
        $this->_userFactory = $userFactory;
    }


    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function login($email, $password)
    {
        $result = array(
            "success" => false,
            "data" => ""
        );
        //$this->validatorHelper->validate($email, $password);
        $collection = $this->getJoinData();
        $selectField = array('id', 'fullname', 'email');
        $data = $collection->addFieldToFilter('email', $email)
            ->addFieldToFilter('password', md5($password))->addFieldToSelect($selectField)
            ->getFirstItem()->getData();
        if ($data) {
            $token = $this->tokenModelFactory->create()->createCustomerToken($data['id'])->getToken();
            $data['token'] = $token;
            $result['success'] = true;
            $result["data"] = $data;
        }
        // TODO: Implement login() method.
        return json_encode($result, true);
    }

    public function getJoinData()
    {
        $collection = $this->_collectionFactory->create();
        $second_table_name = $this->_resource->getTableName('custom_module_user_room');

        $collection->getSelect()->joinLeft(
            array('custom_module_user_room' => $second_table_name),
            'main_table.id = custom_module_user_room.userID',
            ['custom_module_user_room.roomID AS roomID']
        );

        return $collection;

    }

}