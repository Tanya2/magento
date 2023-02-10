<?php

namespace Weather\Meteomatics\Model;

use Weather\Meteomatics\Api\MeteomaticsSearchResultInterface;
use Magento\Framework\Api\SearchResults;

class MeteomaticsSearchResult extends SearchResults implements MeteomaticsSearchResultInterface
{
}
