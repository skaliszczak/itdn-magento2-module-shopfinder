<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace ITDN\Shopfinder\Api\Data;

interface ShopfinderInterface
{

    const NAME = 'name';
    const IDENTIFIER = 'identifier';
    const COUNTRY = 'country';
    const SHOPFINDER_ID = 'shopfinder_id';

    /**
     * Get shopfinder_id
     * @return string|null
     */
    public function getShopfinderId();

    /**
     * Set shopfinder_id
     * @param string $shopfinderId
     * @return \ITDN\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setShopfinderId($shopfinderId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \ITDN\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setName($name);

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return \ITDN\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get country
     * @return string|null
     */
    public function getCountry();

    /**
     * Set country
     * @param string $country
     * @return \ITDN\Shopfinder\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setCountry($country);
}

