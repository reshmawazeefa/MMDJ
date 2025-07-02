02-01-2024
---------------
ALTER TABLE `sales_order_masters` CHANGE `remarks` `remarks` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE `sales_invoice_masters` CHANGE `remarks` `remarks` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE `sales_return_masters` CHANGE `remarks` `remarks` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE `purchase_order_masters` CHANGE `remarks` `remarks` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE `stock_transfer_requests` CHANGE `remarks` `remarks` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE `goods_return_masters` CHANGE `remarks` `remarks` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE `purchase_invoice_masters` CHANGE `remarks` `remarks` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE `purchase_return_masters` CHANGE `remarks` `remarks` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;