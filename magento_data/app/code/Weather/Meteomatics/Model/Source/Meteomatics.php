<?php

namespace Weather\Meteomatics\Model\Source;

use Weather\Meteomatics\Model\ResourceModel\Meteomatics\Collection;

class Meteomatics extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    private Collection $collection;

    /** @var array */
    private $options;


    public function __construct(
        Collection $collection
    ){
        $this->collection = $collection;
    }

    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = $this->collection->toOptionArray();
            $this->options[] = ['value' => '', 'label' => '---Select---'];
        }

        return $this->options;
    }

    public function getAllOptions()
    {
        return $this->toOptionArray();
    }
}
