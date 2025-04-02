Shopfinder - Magento Task
=============

Shopfinder Admin
-------------
 - Content -> Shopfinder
 - ITDN -> Shopfinder

GraphQL
-------------

Listing

    {
        shopfinderList {
            shopfinder_id
            name
            identifier
            country
        }
    }

Fetch One

    {
        shopfinder(shopfinder_id: "1") {
            shopfinder_id
            name
            identifier
            country
        }
    }

Update

    mutation {
        updateShopfinder(
            shopfinder_id: "1",
            country: "US"
        ) {
            shopfinder_id
            name
            identifier
            country
        }
    }

Delete (Blocked)

    mutation {
        deleteShopfinder(shopfinder_id: 1) {
            shopfinder_id
        }
    }