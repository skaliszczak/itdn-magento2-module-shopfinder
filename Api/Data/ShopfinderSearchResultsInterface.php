<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace ITDN\Shopfinder\Api\Data;

interface ShopfinderSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Shopfinder list.
     * @return \ITDN\Shopfinder\Api\Data\ShopfinderInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \ITDN\Shopfinder\Api\Data\ShopfinderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

