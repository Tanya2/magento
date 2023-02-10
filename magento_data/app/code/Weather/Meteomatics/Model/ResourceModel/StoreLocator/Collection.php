<?php

namespace Weather\Meteomatics\Model\ResourceModel\StoreLocator;

use Weather\Meteomatics\Model\StoreLocator;
use Weather\Meteomatics\Model\ResourceModel\StoreLocator as StoreLocatorResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'store_locator_id';
    protected $_eventPrefix = 'weather_meteomatics_store_locator_collection';
    protected $_eventObject = 'store_locator_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(StoreLocator::class, StoreLocatorResource::class);
    }
}
