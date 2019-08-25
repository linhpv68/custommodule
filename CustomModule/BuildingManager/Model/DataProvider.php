<?php
/**
 * cms-nckh - DataProvider.php
 *
 * Initial version by: linhphung
 * Initial version create on : 06/07/2019
 *
 */

namespace CustomModule\BuildingManager\Model;

 use Magento\Ui\DataProvider\AbstractDataProvider;
 use CustomModule\BuildingManager\Model\ResourceModel\User\CollectionFactory;
class DataProvider extends AbstractDataProvider
{

    protected $_loadedData;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,

        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $user) {
            $this->_loadedData[$user->getId()] = $user->getData();
        }
        return $this->_loadedData;
    }

}