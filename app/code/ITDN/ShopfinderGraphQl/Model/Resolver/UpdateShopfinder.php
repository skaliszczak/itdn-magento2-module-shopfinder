<?php

declare(strict_types=1);

namespace ITDN\ShopfinderGraphQl\Model\Resolver;

use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use ITDN\Shopfinder\Model\ShopfinderFactory;
use ITDN\Shopfinder\Model\ResourceModel\Shopfinder as ShopfinderResource;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;

class UpdateShopfinder implements ResolverInterface
{
    /** @var int[]  */
    protected const PROPERTIES_VALIDATION_RULES = ['name' => 512, 'identifier' => 256, 'country' => 2];

    /** @var ShopfinderFactory  */
    protected ShopfinderFactory $shopfinderFactory;

    /** @var ShopfinderResource  */
    protected ShopfinderResource $shopfinderResource;

    public function __construct(
        ShopfinderFactory $shopfinderFactory,
        ShopfinderResource $shopfinderResource
    ) {
        $this->shopfinderFactory = $shopfinderFactory;
        $this->shopfinderResource = $shopfinderResource;
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

        $shop = $this->shopfinderFactory->create();
        $this->shopfinderResource->load($shop, $args['shopfinder_id']);

        if (!$shop->getId()) {
            throw new NoSuchEntityException(__('Shopfinder with ID %1 not found', $args['shopfinder_id']));
        }

        try {
            foreach (static::PROPERTIES_VALIDATION_RULES as $property => $length) {
                if (!array_key_exists($property, $args)) {
                    continue;
                }
                if (strlen($args[$property]) > $length) {
                    throw new LocalizedException(__('Property %1 exeeds max length of %2', $property, $length));
                }
                $shop->setData($property, $args[$property]);
            }
            $this->shopfinderResource->save($shop);

            return [
                'shopfinder_id' => (int) $shop->getData('shopfinder_id'),
                'name' => $shop->getData('name'),
                'identifier' => $shop->getData('identifier'),
                'country' => $shop->getData('country'),
            ];
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__('Unable to update shopfinder: %1', $exception->getMessage()));
        }
    }
}
