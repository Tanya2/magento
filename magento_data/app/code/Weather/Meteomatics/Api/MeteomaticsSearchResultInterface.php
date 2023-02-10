<?php

namespace Weather\Meteomatics\Api;

interface MeteomaticsSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Weather\Meteomatics\Api\Data\MeteomaticsInterface[]
     */
    public function getItems();

    /**
     * @param \Weather\Meteomatics\Api\Data\MeteomaticsInterface[]
     * @return void
     */
    public function setItems(array $items);
}
