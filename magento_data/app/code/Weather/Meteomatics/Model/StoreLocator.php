<?php

namespace Weather\Meteomatics\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class StoreLocator extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'weather_meteomatics_store_locator';

    protected $_cacheTag = 'weather_meteomatics_store_locator';

    protected $_eventPrefix = 'weather_meteomatics_store_locator';

    protected function _construct()
    {
        $this->_init('Weather\Meteomatics\Model\ResourceModel\StoreLocator');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
