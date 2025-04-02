<?php

declare(strict_types=1);

namespace ITDN\ShopfinderGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class DeleteShopfinder implements ResolverInterface
{
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        throw new GraphQlInputException(__('Deletion of Shopfinder records is not allowed.'));
    }
}
