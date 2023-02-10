<?php

namespace Weather\Meteomatics\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Weather\Meteomatics\Model\ResourceModel\Meteomatics\CollectionFactory;
use Weather\Meteomatics\Model\Meteomatics as MeteomaticsModel;

class Meteomatics implements ResolverInterface
{
    private CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array|array[]
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null)
    {
        $collection = $this->collectionFactory->create();

        if (empty($collection)) {
            return [];
        }

        $items = [];

        /** @var MeteomaticsModel $meteomatics */
        foreach ($collection->getItems() as $meteomatics) {
            $items[] = [
                'id' => $meteomatics->getId(),
                't_2m' => $meteomatics->getTemperature(),
                'wind_speed_10m' => $meteomatics->getWindSpeed(),
            ];
        }

        return ['items' => $items];
    }
}
