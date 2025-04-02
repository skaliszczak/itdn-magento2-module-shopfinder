<?php

declare(strict_types=1);

namespace ITDN\ShopfinderGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use ITDN\Shopfinder\Model\ShopfinderFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class Shopfinder implements ResolverInterface
{
    protected ShopfinderFactory $shopfinderFactory;

    public function __construct(ShopfinderFactory $shopfinderFactory)
    {
        $this->shopfinderFactory = $shopfinderFactory;
    }

    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($args['shopfinder_id'])) {
            throw new NoSuchEntityException(__('Shopfinder ID is required'));
        }

        $shop = $this->shopfinderFactory->create()->load($args['shopfinder_id']);
        if (!$shop->getId()) {
            throw new NoSuchEntityException(__('Shopfinder with ID %1 not found', $args['shopfinder_id']));
        }

        return [
            'shopfinder_id' => (int) $shop->getData('shopfinder_id'),
            'name' => $shop->getData('name'),
            'identifier' => $shop->getData('identifier'),
            'country' => $shop->getData('country'),
        ];
    }
}
