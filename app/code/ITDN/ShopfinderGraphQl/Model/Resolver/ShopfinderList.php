<?php

declare(strict_types=1);

namespace ITDN\ShopfinderGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use ITDN\Shopfinder\Model\ResourceModel\Shopfinder\CollectionFactory;

class ShopfinderList implements ResolverInterface
{
    protected CollectionFactory $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $collection = $this->collectionFactory->create();
        $result = [];

        foreach ($collection as $shop) {
            $result[] = [
                'shopfinder_id' => (int) $shop->getData('shopfinder_id'),
                'name' => $shop->getData('name'),
                'identifier' => $shop->getData('identifier'),
                'country' => $shop->getData('country'),
            ];
        }

        return $result;
    }
}
