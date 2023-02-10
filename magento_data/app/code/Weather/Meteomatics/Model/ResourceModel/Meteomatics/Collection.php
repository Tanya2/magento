<?php

namespace Weather\Meteomatics\Model\ResourceModel\Meteomatics;

use Weather\Meteomatics\Api\Data\MeteomaticsInterface;
use Weather\Meteomatics\Model\Meteomatics;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Weather\Meteomatics\Model\ResourceModel\Meteomatics as MeteomaticsResource;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'weather_meteomatics_id';

    protected function _construct()
    {
        $this->_init(Meteomatics::class, MeteomaticsResource::class);
    }

    /**
     * Convert to option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray(MeteomaticsInterface::ID, MeteomaticsInterface::T_2);
    }
}
