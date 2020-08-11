-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for dbstock
CREATE DATABASE IF NOT EXISTS `dbstock` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dbstock`;

-- Dumping structure for table dbstock.brands
CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(12) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.cld_payments
CREATE TABLE IF NOT EXISTS `cld_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `closelist_delivery_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `paiddate` datetime NOT NULL,
  `paidamt` decimal(18,2) NOT NULL,
  `desr` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.closelist_deliveries
CREATE TABLE IF NOT EXISTS `closelist_deliveries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `olddebt` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `cur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalall` decimal(18,2) NOT NULL,
  `deposit` decimal(18,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.companies
CREATE TABLE IF NOT EXISTS `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.deliveries
CREATE TABLE IF NOT EXISTS `deliveries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.exchanges
CREATE TABLE IF NOT EXISTS `exchanges` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `exchange_cur` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buy` decimal(18,2) NOT NULL,
  `sale` decimal(18,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.expanses
CREATE TABLE IF NOT EXISTS `expanses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dd` datetime NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double(8,2) NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `cur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.laws
CREATE TABLE IF NOT EXISTS `laws` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `stock` int(12) NOT NULL DEFAULT '0',
  `itemunit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costprice` decimal(20,4) NOT NULL,
  `cur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stockdate` datetime DEFAULT NULL,
  `stock1` int(11) DEFAULT NULL,
  `amount1` decimal(18,6) DEFAULT NULL,
  `qty_target` int(10) DEFAULT '0',
  `target_unit` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty_score` int(12) DEFAULT '0',
  `scoreprice` decimal(20,4) DEFAULT '0.0000',
  `scorecur` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score_id` int(11) DEFAULT NULL,
  `formonth` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foryear` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.product_barcodes
CREATE TABLE IF NOT EXISTS `product_barcodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `cur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `multiple` tinyint(4) NOT NULL COMMENT 'khmer=meikun',
  `dealer` decimal(20,4) NOT NULL DEFAULT '0.0000',
  `member` decimal(20,4) NOT NULL DEFAULT '0.0000',
  `vip` decimal(20,4) NOT NULL DEFAULT '0.0000',
  `suppervip` decimal(20,4) NOT NULL DEFAULT '0.0000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `barcode` (`barcode`),
  KEY `product_barcodes_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=286 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.product_scores
CREATE TABLE IF NOT EXISTS `product_scores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dd` datetime NOT NULL,
  `product_id` int(11) NOT NULL,
  `qtyset` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `cur` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formonth` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foryear` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invdate` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `carnum` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invnote` text COLLATE utf8mb4_unicode_ci,
  `subtotal` decimal(18,2) NOT NULL,
  `shipcost` decimal(8,0) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `cur` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deposit` decimal(18,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(18,2) DEFAULT NULL,
  `p_paid` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'percent paid',
  `close` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.purchase_details
CREATE TABLE IF NOT EXISTS `purchase_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtycut` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unitprice` decimal(18,2) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `cur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `focunit` int(10) NOT NULL DEFAULT '0',
  `sunit` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `multiunit` int(11) NOT NULL,
  `qtyunit` int(11) NOT NULL,
  `submit` tinyint(1) NOT NULL DEFAULT '0',
  `submitdate` datetime DEFAULT NULL,
  `invdiscount` float(4,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=335 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.purchase_payments
CREATE TABLE IF NOT EXISTS `purchase_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dd` datetime NOT NULL,
  `paidamt` decimal(18,2) NOT NULL,
  `cur` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paynote` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymethod` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.salecloselistpayments
CREATE TABLE IF NOT EXISTS `salecloselistpayments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `salecloselist_id` int(11) NOT NULL,
  `paydate` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `payamt` decimal(20,4) NOT NULL,
  `cur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` decimal(20,4) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.salecloselists
CREATE TABLE IF NOT EXISTS `salecloselists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dd` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `d1` datetime NOT NULL,
  `d2` datetime NOT NULL,
  `d1d2` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ivamount` decimal(18,2) NOT NULL,
  `ivdeposit` decimal(18,2) NOT NULL,
  `ivbalance` decimal(18,2) NOT NULL,
  `oldlist` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `deposit` decimal(18,2) NOT NULL,
  `cur` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `islast` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.sales
CREATE TABLE IF NOT EXISTS `sales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invdate` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `buyinv` int(12) DEFAULT NULL,
  `buyfrom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carfee` decimal(18,2) NOT NULL DEFAULT '0.00',
  `totalweight` int(10) NOT NULL,
  `totaldelivery` decimal(18,2) NOT NULL,
  `deposit_carfee` decimal(18,2) NOT NULL DEFAULT '0.00',
  `law_id` int(11) DEFAULT NULL,
  `lawfee` decimal(18,2) NOT NULL DEFAULT '0.00',
  `deposit_lawfee` decimal(18,2) NOT NULL DEFAULT '0.00',
  `delivery_id` int(11) NOT NULL,
  `carnum` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invnote` text COLLATE utf8mb4_unicode_ci,
  `subtotal` decimal(18,2) NOT NULL,
  `shipcost` decimal(10,2) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `cur` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deposit` decimal(18,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(18,2) NOT NULL,
  `p_paid` tinyint(3) NOT NULL DEFAULT '0',
  `close` int(12) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.sale_details
CREATE TABLE IF NOT EXISTS `sale_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtycut` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unitprice` decimal(18,2) NOT NULL,
  `discount` float(4,2) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `cur` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `focunit` int(10) NOT NULL,
  `sunit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `multiunit` int(11) NOT NULL,
  `qtyunit` int(11) NOT NULL,
  `submit` tinyint(1) NOT NULL DEFAULT '0',
  `submitdate` datetime DEFAULT NULL,
  `cost` decimal(18,6) NOT NULL,
  `costcur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costex` decimal(22,6) NOT NULL,
  `invdiscount` float(4,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=352 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.sale_payments
CREATE TABLE IF NOT EXISTS `sale_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dd` datetime NOT NULL,
  `paidamt` decimal(18,2) NOT NULL,
  `cur` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paynote` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymethod` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.stock_processes
CREATE TABLE IF NOT EXISTS `stock_processes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dd` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `mode` tinyint(4) NOT NULL COMMENT '0=closestock 1=add stock -1=sub stock',
  `desr` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(20,4) NOT NULL,
  `cur` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=281 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_slug` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `type` int(11) NOT NULL COMMENT '1=customer 0=supplier',
  `customercode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `customerprice` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.units
CREATE TABLE IF NOT EXISTS `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
-- Dumping structure for table dbstock.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
