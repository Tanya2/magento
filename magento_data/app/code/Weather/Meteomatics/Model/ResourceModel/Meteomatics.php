<?php

namespace Weather\Meteomatics\Model\ResourceModel;

use Weather\Meteomatics\Api\Data\MeteomaticsInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Meteomatics extends AbstractDb
{
    public const TABLE_NAME = 'weather_meteomatics';

    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, MeteomaticsInterface::ID);
    }
}
