-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2018 at 10:18 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chain`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_test`()
    MODIFIES SQL DATA
BEGIN
DECLARE qty_out INT(11);
SELECT A.*, ( SELECT C.title FROM mrp_satuan_group AS B LEFT JOIN mrp_satuan AS C ON B.id_mrp_satuan_group = C.id_mrp_satuan_group WHERE C.type = 1 AND B.id_mrp_satuan_group = A.id_mrp_satuan_group) AS satuan, func_mrp_sum_qty_stock(A.id_mrp_inventory, 1, 'FJUOUNAUWAVYY') AS qty_in, func_mrp_sum_qty_stock(A.id_mrp_inventory, 2, 'FJUOUNAUWAVYY') AS qty_dout INTO qty_out FROM mrp_inventory AS A ORDER BY A.code DESC LIMIT 0, 20;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_mrp_set_produksi_inventory`(IN `in_id_users` INT(11), IN `in_create` DATETIME, IN `in_id_mrp_satuan` INT(11), IN `in_id_mrp_storage` VARCHAR(20), IN `in_qty` INT(11), IN `in_id_mrp_informasi_inventory` VARCHAR(20), IN `in_id_mrp_inventory` INT(11), IN `in_tanggal_produksi` DATE, IN `in_code_produksi` VARCHAR(100), IN `in_tanggal_kadaluarsa` DATE, IN `in_id_mrp_inventory_stock` VARCHAR(20), IN `in_tanggal_masuk` DATETIME, IN `in_hpp` DOUBLE, IN `in_note` TEXT, IN `in_type` TINYINT(1))
BEGIN
	DECLARE in_id_mrp_storage_rak varchar(20);
	DECLARE in_id_mrp_satuan_terkecil int(11);
	DECLARE in_qty_masuk int(11);
	DECLARE in_hpp_terkecil double;
	DECLARE in_nilai int(11);

	SELECT id_mrp_storage_rak INTO in_id_mrp_storage_rak
	FROM mrp_storage_rak
	WHERE id_mrp_storage = in_id_mrp_storage
	AND type = 2;

	SELECT nilai INTO in_nilai
	FROM mrp_satuan
	WHERE id_mrp_satuan = in_id_mrp_satuan;

	SET in_qty_masuk = in_qty * in_nilai;
	SET in_id_mrp_satuan_terkecil = func_mrp_satuan_terkecil(in_id_mrp_satuan);
	SET in_hpp_terkecil = in_hpp/in_qty_masuk;

	INSERT INTO mrp_informasi_inventory (id_mrp_informasi_inventory, id_mrp_inventory, tanggal_produksi, code_produksi, tanggal_kadaluarsa, hpp, create_by_users, create_date, id_mrp_storage)
 	VALUES (in_id_mrp_informasi_inventory, in_id_mrp_inventory, in_tanggal_produksi, in_code_produksi, in_tanggal_kadaluarsa, in_hpp_terkecil, in_id_users, in_create, in_id_mrp_storage);

	INSERT INTO mrp_inventory_stock_in (id_mrp_inventory_stock_in, id_mrp_storage_rak, id_mrp_satuan, id_mrp_informasi_inventory, tanggal_masuk, qty_masuk, note, type, create_by_users, create_date)
 	VALUES (in_id_mrp_inventory_stock, in_id_mrp_storage_rak, in_id_mrp_satuan_terkecil, in_id_mrp_informasi_inventory, in_tanggal_masuk, in_qty_masuk, in_note, in_type, in_id_users, in_create);
 	
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `func_mrp_rg_count_qty_return`(`in_id_mrp_mutasi_inventory` VARCHAR(20), `in_qty` INT) RETURNS int(11)
    READS SQL DATA
    DETERMINISTIC
BEGIN
DECLARE qty_return int;

 SELECT (qty - in_qty)
INTO qty_return
FROM mrp_mutasi_inventory
WHERE id_mrp_mutasi_inventory = in_id_mrp_mutasi_inventory;

 RETURN (qty_return);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `func_mrp_satuan_terkecil`(`in_id_mrp_satuan` INT(11)) RETURNS int(11)
    READS SQL DATA
BEGIN
DECLARE in_id_mrp_satuan_group int;
DECLARE out_id_mrp_satuan int;

SELECT id_mrp_satuan_group
INTO in_id_mrp_satuan_group
FROM mrp_satuan
WHERE id_mrp_satuan = in_id_mrp_satuan;

SELECT id_mrp_satuan
INTO out_id_mrp_satuan
FROM mrp_satuan
WHERE id_mrp_satuan_group = in_id_mrp_satuan_group AND type = 1;

RETURN (out_id_mrp_satuan);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `func_mrp_sum_qty_stock`(`in_id_mrp_inventory` INT, `in_type` TINYINT(1), `in_id_mrp_storage` VARCHAR(20)) RETURNS int(11)
    NO SQL
BEGIN
DECLARE qty_return INT(11);
IF in_type = 1 THEN
SELECT SUM(IF(A.qty IS NULL, 0, A.qty)) INTO qty_return
FROM mrp_informasi_inventory AS A
WHERE A.id_mrp_inventory = in_id_mrp_inventory AND A.id_mrp_storage = in_id_mrp_storage;
ELSE
SELECT SUM(IF(A.qty_out IS NULL, 0, A.qty_out)) INTO qty_return
FROM mrp_informasi_inventory AS A
WHERE A.id_mrp_inventory = in_id_mrp_inventory AND A.id_mrp_storage = in_id_mrp_storage;
END IF;
RETURN qty_return;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE IF NOT EXISTS `api_keys` (
  `id_api_keys` varchar(25) NOT NULL,
  `id_api_users` varchar(25) NOT NULL,
  `kunci` varchar(40) NOT NULL,
  `batas` datetime DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `api_users`
--

CREATE TABLE IF NOT EXISTS `api_users` (
  `id_api_users` varchar(25) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `sandi` varchar(200) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `id_users_tms` int(11) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bridge`
--

CREATE TABLE IF NOT EXISTS `bridge` (
  `id_bridge` varchar(20) NOT NULL,
  `redirect` varchar(200) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bridge_users`
--

CREATE TABLE IF NOT EXISTS `bridge_users` (
  `id_bridge_users` varchar(20) NOT NULL,
  `id_bridge` varchar(20) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id_users_partner` varchar(100) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cms_article`
--

CREATE TABLE IF NOT EXISTS `cms_article` (
  `id_cms_article` varchar(25) NOT NULL,
  `link` varchar(25) DEFAULT NULL,
  `title` varchar(25) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>tidak aktif, 2=>aktif',
  `file` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cms_banner_promo`
--

CREATE TABLE IF NOT EXISTS `cms_banner_promo` (
  `id_cms_banner_promo` varchar(20) NOT NULL,
  `code` varchar(25) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>tidak aktif, 2=>aktif',
  `file` text,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `sort` tinyint(3) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cms_comment`
--

CREATE TABLE IF NOT EXISTS `cms_comment` (
  `id_cms_comment` varchar(25) NOT NULL,
  `id_cms_article` varchar(25) DEFAULT NULL,
  `title` varchar(25) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>tidak aktif, 2=>aktif',
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cms_gallery`
--

CREATE TABLE IF NOT EXISTS `cms_gallery` (
  `id_cms_gallery` varchar(25) NOT NULL,
  `title` varchar(25) DEFAULT NULL,
  `link` varchar(25) DEFAULT NULL,
  `file` text,
  `note` varchar(25) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cms_page`
--

CREATE TABLE IF NOT EXISTS `cms_page` (
  `id_cms_page` varchar(25) NOT NULL,
  `link` varchar(25) DEFAULT NULL,
  `title` varchar(25) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>tidak aktif, 2=>aktif',
  `file` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cms_service`
--

CREATE TABLE IF NOT EXISTS `cms_service` (
  `id_cms_service` varchar(25) NOT NULL,
  `title` varchar(35) DEFAULT NULL,
  `file` text,
  `link` varchar(35) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_agent`
--

CREATE TABLE IF NOT EXISTS `crm_agent` (
  `id_crm_agent` varchar(20) NOT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id_crm_agent_store` varchar(20) DEFAULT NULL,
  `title` tinyint(1) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telp` varchar(100) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_agent_store`
--

CREATE TABLE IF NOT EXISTS `crm_agent_store` (
  `id_crm_agent_store` varchar(20) NOT NULL,
  `title` varchar(35) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `sort` int(2) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `address` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer`
--

CREATE TABLE IF NOT EXISTS `crm_customer` (
  `id_crm_customer` varchar(20) NOT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `title` tinyint(1) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telp` varchar(100) DEFAULT NULL,
  `telp_home` varchar(100) DEFAULT NULL,
  `division` varchar(100) DEFAULT NULL,
  `handphone` varchar(100) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_company`
--

CREATE TABLE IF NOT EXISTS `crm_customer_company` (
  `id_crm_customer_company` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `code` text,
  `status` tinyint(1) DEFAULT NULL,
  `pricing_type` tinyint(1) DEFAULT NULL,
  `margin` double DEFAULT NULL,
  `management_fee` double DEFAULT NULL,
  `note` text,
  `utama` tinyint(1) DEFAULT '1',
  `type` tinyint(3) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `telp` varchar(100) DEFAULT NULL,
  `telp2` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_company_credit`
--

CREATE TABLE IF NOT EXISTS `crm_customer_company_credit` (
  `id_crm_customer_company_credit` varchar(20) NOT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `batas` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_company_credit_log`
--

CREATE TABLE IF NOT EXISTS `crm_customer_company_credit_log` (
  `id_crm_customer_company_credit_log` varchar(20) NOT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id` varchar(20) DEFAULT NULL,
  `tabledatabase` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1-10 in, 11-20 out',
  `in` double DEFAULT NULL,
  `out` double DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_company_deposit`
--

CREATE TABLE IF NOT EXISTS `crm_customer_company_deposit` (
  `id_crm_customer_company_deposit` varchar(20) NOT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_company_deposit_log`
--

CREATE TABLE IF NOT EXISTS `crm_customer_company_deposit_log` (
  `id_crm_customer_company_deposit_log` varchar(20) NOT NULL,
  `id_crm_customer_company_deposit` varchar(20) DEFAULT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id` varchar(20) DEFAULT NULL,
  `tabledatabase` varchar(100) DEFAULT NULL,
  `nomor` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1-10 in, 11-20 out',
  `credit` double DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `note` text,
  `ispoint` tinyint(1) DEFAULT '2',
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_company_discount`
--

CREATE TABLE IF NOT EXISTS `crm_customer_company_discount` (
  `id_crm_customer_company_discount` varchar(20) NOT NULL,
  `id_crm_customer_company` int(11) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_deposit`
--

CREATE TABLE IF NOT EXISTS `crm_customer_deposit` (
  `id_crm_customer_deposit` varchar(20) NOT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_deposit_log`
--

CREATE TABLE IF NOT EXISTS `crm_customer_deposit_log` (
  `id_crm_customer_deposit_log` varchar(20) NOT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id` varchar(20) DEFAULT NULL,
  `tabledatabase` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1-10 in, 11-20 out',
  `in` double DEFAULT NULL,
  `out` double DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_users_deposit`
--

CREATE TABLE IF NOT EXISTS `crm_customer_users_deposit` (
  `id_crm_customer_users_deposit` varchar(20) NOT NULL,
  `id_users` int(11) DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer_users_deposit_log`
--

CREATE TABLE IF NOT EXISTS `crm_customer_users_deposit_log` (
  `id_crm_customer_users_deposit_log` varchar(20) NOT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id_users_set` int(11) DEFAULT NULL,
  `id` varchar(20) DEFAULT NULL,
  `tabledatabase` varchar(100) DEFAULT NULL,
  `nomor` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1-10 in, 11-20 out',
  `credit` double DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `note` text,
  `ispoint` tinyint(1) DEFAULT '2',
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_approval_privilege`
--

CREATE TABLE IF NOT EXISTS `crm_pos_approval_privilege` (
  `id_crm_pos_approval_privilege` varchar(20) NOT NULL,
  `id_crm_pos_approval_settings` varchar(20) DEFAULT NULL,
  `id_privilege` int(11) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_approval_settings`
--

CREATE TABLE IF NOT EXISTS `crm_pos_approval_settings` (
  `id_crm_pos_approval_settings` varchar(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_discount`
--

CREATE TABLE IF NOT EXISTS `crm_pos_discount` (
  `id_crm_pos_discount` varchar(20) NOT NULL,
  `nilai` double DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `bataswaktu` tinyint(1) DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `editable` tinyint(1) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `is_company` tinyint(4) DEFAULT NULL,
  `is_payment_channel` tinyint(1) DEFAULT NULL,
  `is_voucher` tinyint(1) DEFAULT NULL,
  `minimum` double DEFAULT NULL,
  `maximum` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `bertingkat` tinyint(1) DEFAULT NULL,
  `sort` tinyint(1) DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `merchandise` tinyint(1) DEFAULT NULL,
  `cashback` tinyint(1) DEFAULT '2',
  `code` varchar(100) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `nameinprint` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_discount_company`
--

CREATE TABLE IF NOT EXISTS `crm_pos_discount_company` (
  `id_crm_pos_discount_company` int(11) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_discount_merchandise`
--

CREATE TABLE IF NOT EXISTS `crm_pos_discount_merchandise` (
  `id_crm_pos_discount_merchandise` varchar(20) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `id_crm_pos_products_merchandise` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_discount_payment_channel`
--

CREATE TABLE IF NOT EXISTS `crm_pos_discount_payment_channel` (
  `id_crm_pos_discount_payment_channel` varchar(20) NOT NULL,
  `id_crm_payment_channel` varchar(20) DEFAULT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_discount_set`
--

CREATE TABLE IF NOT EXISTS `crm_pos_discount_set` (
  `id_crm_pos_discount_set` varchar(20) NOT NULL,
  `id_crm_pos_approval_settings` varchar(20) DEFAULT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_discount_voucher`
--

CREATE TABLE IF NOT EXISTS `crm_pos_discount_voucher` (
  `id_crm_pos_discount_voucher` varchar(20) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `batas` int(11) DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `digunakan` double DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_discount_voucher_use`
--

CREATE TABLE IF NOT EXISTS `crm_pos_discount_voucher_use` (
  `id_crm_pos_discount_voucher_use` varchar(20) NOT NULL,
  `id_crm_pos_discount_voucher` varchar(20) DEFAULT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `source_table` varchar(200) DEFAULT NULL,
  `source_id` varchar(200) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `timelimit` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_location`
--

CREATE TABLE IF NOT EXISTS `crm_pos_location` (
  `id_crm_pos_location` varchar(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `urut` tinyint(3) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_location_dc`
--

CREATE TABLE IF NOT EXISTS `crm_pos_location_dc` (
  `id_crm_pos_location_dc` varchar(20) NOT NULL,
  `id_crm_pos_location` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `urut` tinyint(3) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_order`
--

CREATE TABLE IF NOT EXISTS `crm_pos_order` (
  `id_crm_pos_order` varchar(20) NOT NULL,
  `id_crm_pos_order_reference` varchar(20) DEFAULT NULL,
  `id_rev_crm_pos_order` varchar(20) DEFAULT NULL,
  `id_crm_pos_quotation` varchar(20) DEFAULT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `id_crm_agent` varchar(20) DEFAULT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id_crm_pos_products_categories` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nomor` varchar(50) DEFAULT NULL,
  `urut` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `industry` tinyint(3) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `rev` tinyint(3) DEFAULT NULL,
  `print_note` text,
  `note_decision` text,
  `note_cancel` text,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_order_cashback`
--

CREATE TABLE IF NOT EXISTS `crm_pos_order_cashback` (
  `id_crm_pos_order_cashback` varchar(20) NOT NULL,
  `id_crm_pos_order` varchar(20) DEFAULT NULL,
  `id_crm_cashback` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id_users_decision` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `note_decision` text,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_order_charge`
--

CREATE TABLE IF NOT EXISTS `crm_pos_order_charge` (
  `id_crm_pos_order_charge` varchar(20) NOT NULL,
  `id_crm_pos_order` varchar(20) DEFAULT NULL,
  `id_site_transport_spj` varchar(20) DEFAULT NULL,
  `id_crm_pos_order_old` varchar(20) DEFAULT NULL,
  `id_crm_payment` varchar(20) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_order_discount`
--

CREATE TABLE IF NOT EXISTS `crm_pos_order_discount` (
  `id_crm_pos_order_discount` varchar(20) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `id_crm_pos_order` varchar(20) DEFAULT NULL,
  `id_crm_pos_approval_settings` varchar(20) DEFAULT NULL,
  `id_crm_pos_quotation_discount` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `nilai_dari` double DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1 => create, 2 => approve, 3 => cancel, 4 => need approve, 5 => rejected',
  `bertingkat` tinyint(1) DEFAULT NULL,
  `sort` tinyint(1) DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_order_discount_cashback`
--

CREATE TABLE IF NOT EXISTS `crm_pos_order_discount_cashback` (
  `id_crm_pos_order_discount_cashback` varchar(20) NOT NULL,
  `id_crm_pos_order_cashback` varchar(20) DEFAULT NULL,
  `id_crm_pos_order_discount` varchar(20) DEFAULT NULL,
  `id_crm_pos_order` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `nilai_dari` double DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_order_merchandise`
--

CREATE TABLE IF NOT EXISTS `crm_pos_order_merchandise` (
  `id_crm_pos_order_merchandise` varchar(20) NOT NULL,
  `id_crm_pos_products_merchandise` varchar(20) DEFAULT NULL,
  `id_crm_pos_order` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `price` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price_dasar` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_order_merchandise_addon`
--

CREATE TABLE IF NOT EXISTS `crm_pos_order_merchandise_addon` (
  `id_crm_pos_order_merchandise_addon` varchar(20) NOT NULL,
  `id_crm_pos_quotation_merchandise_addon` varchar(20) DEFAULT NULL,
  `id_crm_pos_products_merchandise` varchar(20) DEFAULT NULL,
  `id_crm_pos_order` varchar(20) DEFAULT NULL,
  `id_crm_pos_order_merchandise` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `price` double DEFAULT NULL,
  `category` tinyint(3) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price_dasar` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_order_merchandise_discount`
--

CREATE TABLE IF NOT EXISTS `crm_pos_order_merchandise_discount` (
  `id_crm_pos_order_merchandise_discount` varchar(20) NOT NULL,
  `id_crm_pos_quotation_merchandise_discount` varchar(20) DEFAULT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `id_crm_pos_order_merchandise` varchar(20) DEFAULT NULL,
  `id_crm_pos_approval_settings` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `nilai_dari` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `bertingkat` tinyint(1) DEFAULT NULL,
  `sort` tinyint(1) DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_order_merchandise_discount_cashback`
--

CREATE TABLE IF NOT EXISTS `crm_pos_order_merchandise_discount_cashback` (
  `id_crm_pos_order_merchandise_discount_cashback` varchar(20) NOT NULL,
  `id_crm_pos_order_cashback` varchar(20) DEFAULT NULL,
  `id_crm_pos_order_merchandise_discount` varchar(20) DEFAULT NULL,
  `id_crm_pos_order` varchar(20) DEFAULT NULL,
  `id_crm_pos_order_merchandise` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `nilai_dari` double DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_products`
--

CREATE TABLE IF NOT EXISTS `crm_pos_products` (
  `id_crm_pos_products` varchar(20) NOT NULL,
  `id_crm_pos_products_categories` varchar(20) DEFAULT NULL,
  `id_crm_pos_products_specification` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `selling_point` text,
  `description` text,
  `status` tinyint(1) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_products_categories`
--

CREATE TABLE IF NOT EXISTS `crm_pos_products_categories` (
  `id_crm_pos_products_categories` varchar(20) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_products_file`
--

CREATE TABLE IF NOT EXISTS `crm_pos_products_file` (
  `id_crm_pos_products_file` varchar(20) NOT NULL,
  `id_crm_pos_products` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_products_merchandise`
--

CREATE TABLE IF NOT EXISTS `crm_pos_products_merchandise` (
  `id_crm_pos_products_merchandise` varchar(20) NOT NULL,
  `id_crm_pos_products_merchandise_classification` varchar(20) DEFAULT NULL,
  `id_crm_pos_products` varchar(20) DEFAULT NULL,
  `id_crm_pos_location` varchar(20) DEFAULT NULL,
  `id_crm_pos_location_dc` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `qty` int(7) DEFAULT NULL,
  `qty_out` int(7) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `tambahan` tinyint(1) DEFAULT '2',
  `editable` tinyint(1) DEFAULT '2',
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_products_merchandise_classification`
--

CREATE TABLE IF NOT EXISTS `crm_pos_products_merchandise_classification` (
  `id_crm_pos_products_merchandise_classification` varchar(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `urut` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_products_specification`
--

CREATE TABLE IF NOT EXISTS `crm_pos_products_specification` (
  `id_crm_pos_products_specification` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_products_specification_data`
--

CREATE TABLE IF NOT EXISTS `crm_pos_products_specification_data` (
  `id_crm_pos_products_specification_data` varchar(20) NOT NULL,
  `id_crm_pos_products_specification_details` varchar(20) DEFAULT NULL,
  `id_crm_pos_products` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `isi` text,
  `type` tinyint(1) DEFAULT NULL,
  `sort` tinyint(1) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_products_specification_details`
--

CREATE TABLE IF NOT EXISTS `crm_pos_products_specification_details` (
  `id_crm_pos_products_specification_details` varchar(20) NOT NULL,
  `id_crm_pos_products_specification` varchar(20) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_products_tags`
--

CREATE TABLE IF NOT EXISTS `crm_pos_products_tags` (
  `id_crm_pos_products_tags` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_quotation`
--

CREATE TABLE IF NOT EXISTS `crm_pos_quotation` (
  `id_crm_pos_quotation` varchar(20) NOT NULL,
  `id_rev_crm_pos_quotation` varchar(20) DEFAULT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `id_crm_agent` varchar(20) DEFAULT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id_crm_pos_products_categories` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nomor` varchar(50) DEFAULT NULL,
  `urut` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `rev` tinyint(3) DEFAULT NULL,
  `print_note` tinyint(1) DEFAULT NULL,
  `note` text,
  `note_decision` text,
  `note_cancel` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_quotation_cashback`
--

CREATE TABLE IF NOT EXISTS `crm_pos_quotation_cashback` (
  `id_crm_pos_quotation_cashback` varchar(20) NOT NULL,
  `id_crm_cashback` varchar(20) DEFAULT NULL,
  `id_crm_pos_quotation` varchar(20) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `id_users_decision` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `note_decision` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_quotation_discount`
--

CREATE TABLE IF NOT EXISTS `crm_pos_quotation_discount` (
  `id_crm_pos_quotation_discount` varchar(20) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `id_crm_pos_quotation` varchar(20) DEFAULT NULL,
  `id_crm_pos_approval_settings` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `nilai_dari` double DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1 => create, 2 => approve, 3 => cancel, 4 => need approve, 5 => rejected',
  `bertingkat` tinyint(1) DEFAULT NULL,
  `sort` tinyint(1) DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_quotation_merchandise`
--

CREATE TABLE IF NOT EXISTS `crm_pos_quotation_merchandise` (
  `id_crm_pos_quotation_merchandise` varchar(20) NOT NULL,
  `id_crm_pos_products_merchandise` varchar(20) DEFAULT NULL,
  `id_crm_pos_quotation` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `price` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price_dasar` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_quotation_merchandise_addon`
--

CREATE TABLE IF NOT EXISTS `crm_pos_quotation_merchandise_addon` (
  `id_crm_pos_quotation_merchandise_addon` varchar(20) NOT NULL,
  `id_crm_pos_products_merchandise` varchar(20) DEFAULT NULL,
  `id_crm_pos_quotation` varchar(20) DEFAULT NULL,
  `id_crm_pos_quotation_merchandise` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `price` double DEFAULT NULL,
  `category` tinyint(3) DEFAULT NULL,
  `type` tinyint(3) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price_dasar` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_quotation_merchandise_discount`
--

CREATE TABLE IF NOT EXISTS `crm_pos_quotation_merchandise_discount` (
  `id_crm_pos_quotation_merchandise_discount` varchar(20) NOT NULL,
  `id_crm_pos_discount` varchar(20) DEFAULT NULL,
  `id_crm_pos_quotation_merchandise` varchar(20) DEFAULT NULL,
  `id_crm_pos_approval_settings` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `nilai_dari` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `bertingkat` tinyint(1) DEFAULT NULL,
  `sort` tinyint(1) DEFAULT NULL,
  `approve` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `qty` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_request`
--

CREATE TABLE IF NOT EXISTS `crm_pos_request` (
  `id_crm_pos_request` varchar(20) NOT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `id_crm_customer_company` int(11) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `nomor` varchar(50) DEFAULT NULL,
  `urut` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `note_decision` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crm_pos_request_merchandise`
--

CREATE TABLE IF NOT EXISTS `crm_pos_request_merchandise` (
  `id_crm_pos_request_merchandise` varchar(20) NOT NULL,
  `id_crm_pos_products_merchandise` varchar(20) DEFAULT NULL,
  `id_crm_pos_request` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `price` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price_dasar` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `d_privilege_form`
--

CREATE TABLE IF NOT EXISTS `d_privilege_form` (
  `id_privilege_form` int(11) NOT NULL,
  `id_privilege` int(11) DEFAULT NULL,
  `id_form` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `d_privilege_menu`
--

CREATE TABLE IF NOT EXISTS `d_privilege_menu` (
  `id_privilege_menu` int(11) NOT NULL,
  `id_privilege` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `d_privilege_module`
--

CREATE TABLE IF NOT EXISTS `d_privilege_module` (
  `id_privilege_module` int(11) NOT NULL,
  `id_privilege` int(11) DEFAULT NULL,
  `id_module` int(11) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `d_privilege_page`
--

CREATE TABLE IF NOT EXISTS `d_privilege_page` (
  `id_privilege_page` int(11) NOT NULL,
  `id_privilege` int(11) DEFAULT NULL,
  `id_page` int(11) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `d_session`
--

CREATE TABLE IF NOT EXISTS `d_session` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `d_session`
--

INSERT INTO `d_session` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('9cc6d210d082e4bd59e6d78d9e16c718', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.84 Safari/537.36', 1533636065, 'a:7:{s:9:"user_data";s:0:"";s:4:"name";s:5:"admin";s:5:"email";s:18:"itdev@antavaya.com";s:2:"id";s:1:"1";s:12:"id_privilege";i:0;s:8:"dashbord";N;s:9:"logged_in";b:1;}'),
('b13d34140217116b4f281ec95dc1041f', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.84 Safari/537.36', 1533722797, 'a:7:{s:9:"user_data";s:0:"";s:4:"name";s:5:"admin";s:5:"email";s:18:"itdev@antavaya.com";s:2:"id";s:1:"1";s:12:"id_privilege";i:0;s:8:"dashbord";N;s:9:"logged_in";b:1;}'),
('e3b6bb1ca53699cb0806cffcf6b8c45d', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.84 Safari/537.36', 1534040937, 'a:8:{s:9:"user_data";s:0:"";s:4:"name";s:5:"admin";s:5:"email";s:18:"itdev@antavaya.com";s:2:"id";s:1:"1";s:12:"id_privilege";i:0;s:8:"dashbord";N;s:9:"logged_in";b:1;s:10:"code_users";s:4:"ANTA";}'),
('5f744e3f53456f5ee9cbc978ac915ec5', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.84 Safari/537.36', 1534155274, 'a:8:{s:9:"user_data";s:0:"";s:4:"name";s:5:"admin";s:5:"email";s:18:"itdev@antavaya.com";s:2:"id";s:1:"1";s:12:"id_privilege";i:0;s:8:"dashbord";N;s:9:"logged_in";b:1;s:10:"code_users";s:4:"ANTA";}'),
('fef869cbc401eb4dd3dd038110b9e78c', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 1534319856, 'a:9:{s:9:"user_data";s:0:"";s:4:"name";s:5:"admin";s:5:"email";s:18:"itdev@antavaya.com";s:2:"id";s:1:"1";s:12:"id_privilege";i:0;s:8:"dashbord";N;s:9:"logged_in";b:1;s:10:"code_users";s:4:"ANTA";s:18:"frm_journal_period";s:13:"DDW2Z9PAHPXE7";}'),
('dad04ef4aa76bacbe190695a639a72fd', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 1534327596, 'a:9:{s:9:"user_data";s:0:"";s:4:"name";s:5:"admin";s:5:"email";s:18:"itdev@antavaya.com";s:2:"id";s:1:"1";s:12:"id_privilege";i:0;s:8:"dashbord";N;s:9:"logged_in";b:1;s:10:"code_users";s:4:"ANTA";s:18:"frm_journal_period";s:13:"DDW2Z9PAHPXE7";}'),
('b10fe80019dc3f4572c71c37d74e2cbb', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 1535703040, 'a:7:{s:9:"user_data";s:0:"";s:4:"name";s:5:"admin";s:5:"email";s:18:"itdev@antavaya.com";s:2:"id";s:1:"1";s:12:"id_privilege";i:0;s:8:"dashbord";N;s:9:"logged_in";b:1;}');

-- --------------------------------------------------------

--
-- Table structure for table `frm_account`
--

CREATE TABLE IF NOT EXISTS `frm_account` (
  `id_frm_account` varchar(200) NOT NULL,
  `id_parent` varchar(20) DEFAULT NULL,
  `ref` varchar(200) DEFAULT NULL,
  `code_users` varchar(200) DEFAULT NULL,
  `code` int(10) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `pos` tinyint(1) DEFAULT NULL,
  `position` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `is_group` tinyint(1) DEFAULT NULL,
  `modal` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `frm_account`
--

INSERT INTO `frm_account` (`id_frm_account`, `id_parent`, `ref`, `code_users`, `code`, `title`, `pos`, `position`, `status`, `is_group`, `modal`, `note`, `create_by_users`, `create_date`, `update_by_users`, `update_date`) VALUES
('ANTA1', '', '1', 'ANTA', 1, 'Activa', 1, 1, 1, 1, NULL, NULL, 1, '2018-08-10 16:32:55', NULL, '2018-08-10 09:32:55'),
('ANTA1 1', 'ANTA1', '1 1', 'ANTA', 1, 'Activa Lancar', 1, 1, 1, 2, NULL, NULL, 1, '2018-08-10 16:35:16', NULL, '2018-08-10 09:35:16'),
('ANTA1 1 01', 'ANTA1 1', '1 1 01', 'ANTA', 1, 'Kas & Bank', 1, 1, 1, 3, NULL, NULL, 1, '2018-08-10 16:35:53', NULL, '2018-08-10 09:35:53'),
('ANTA1 1 01 01', 'ANTA1 1 01', '1 1 01 01', 'ANTA', 1, 'Bank', 1, 1, 1, 4, NULL, NULL, 1, '2018-08-10 16:36:05', NULL, '2018-08-10 09:36:05'),
('ANTA1 1 01 01 0001', 'ANTA1 1 01 01', '1 1 01 01 0001', 'ANTA', 1, 'Bank BCA', 1, 1, 1, 5, NULL, NULL, 1, '2018-08-10 16:36:20', NULL, '2018-08-10 09:36:20'),
('ANTA1 1 01 01 0002', 'ANTA1 1 01 01', '1 1 01 01 0002', 'ANTA', 2, 'Bank Mega', 1, 1, 1, 5, NULL, NULL, 1, '2018-08-15 16:30:51', NULL, '2018-08-15 09:30:51'),
('ANTA1 1 01 02', 'ANTA1 1 01', '1 1 01 02', 'ANTA', 2, 'Kas', 1, 1, 1, 4, NULL, NULL, 1, '2018-08-10 16:36:09', NULL, '2018-08-10 09:36:09'),
('ANTA1 1 02', 'ANTA1 1', '1 1 02', 'ANTA', 2, 'Persediaan', 1, 1, 1, 3, NULL, NULL, 1, '2018-08-10 16:40:39', NULL, '2018-08-10 09:40:39'),
('ANTA1 1 02 01', 'ANTA1 1 02', '1 1 02 01', 'ANTA', 1, 'Persediaan Barang Dagang', 1, 1, 1, 4, NULL, NULL, 1, '2018-08-10 16:40:51', NULL, '2018-08-10 09:40:51'),
('ANTA1 1 02 01 0001', 'ANTA1 1 02 01', '1 1 02 01 0001', 'ANTA', 1, 'Aksesoris HP', 1, 1, 1, 5, NULL, NULL, 1, '2018-08-10 16:41:04', NULL, '2018-08-10 09:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `frm_journal`
--

CREATE TABLE IF NOT EXISTS `frm_journal` (
  `id_frm_journal` int(11) NOT NULL,
  `id_frm_journal_period` varchar(20) DEFAULT NULL,
  `code_users` varchar(200) DEFAULT NULL,
  `source_table` varchar(200) DEFAULT NULL,
  `source_id` varchar(20) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `nomor` varchar(100) DEFAULT NULL,
  `urut` int(11) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `frm_journal`
--

INSERT INTO `frm_journal` (`id_frm_journal`, `id_frm_journal_period`, `code_users`, `source_table`, `source_id`, `title`, `code`, `tanggal`, `nomor`, `urut`, `note`, `status`, `create_by_users`, `create_date`, `update_by_users`, `update_date`) VALUES
(1, 'DDW2Z9PAHPXE7', 'ANTA', NULL, NULL, '', NULL, '2018-08-13 16:12:00', 'FRM-201808-01', 1, NULL, 5, 1, '2018-08-13 16:12:24', NULL, '2018-08-13 09:12:24'),
(2, 'DDW2Z9PAHPXE7', 'ANTA', NULL, NULL, '', NULL, '2018-08-13 16:33:00', 'FRM-201808-02', 2, NULL, 5, 1, '2018-08-13 16:33:30', NULL, '2018-08-13 09:33:30'),
(3, 'DDW2Z9PAHPXE7', 'ANTA', NULL, NULL, '', NULL, '2018-08-13 16:34:00', 'FRM-201808-03', 3, NULL, 5, 1, '2018-08-13 16:34:34', NULL, '2018-08-13 09:34:34'),
(4, 'DDW2Z9PAHPXE7', 'ANTA', NULL, NULL, '', NULL, '2018-08-13 16:34:00', 'FRM-201808-04', 4, NULL, 5, 1, '2018-08-13 16:34:43', NULL, '2018-08-13 09:34:43'),
(5, 'DDW2Z9PAHPXE7', 'ANTA', NULL, NULL, '', NULL, '2018-08-13 16:42:00', 'FRM-201808-05', 5, NULL, 1, 1, '2018-08-13 16:42:48', 1, '2018-08-13 09:43:01'),
(6, 'DDW2Z9PAHPXE7', 'ANTA', NULL, NULL, 'Balik', NULL, '2018-08-13 16:45:00', 'FRM-201808-06', 6, '', 1, 1, '2018-08-13 16:45:46', 1, '2018-08-13 09:45:57'),
(7, 'DDW2Z9PAHPXE7', 'ANTA', NULL, NULL, 'salah', NULL, '2018-08-13 16:47:00', 'FRM-201808-07', 7, '', 1, 1, '2018-08-13 16:48:05', 1, '2018-08-13 09:48:42'),
(8, 'DDW2Z9PAHPXE7', 'ANTA', NULL, NULL, 'Asli', NULL, '2018-08-13 16:49:00', 'FRM-201808-08', 8, '', 1, 1, '2018-08-13 16:49:49', 1, '2018-08-13 09:49:59'),
(9, 'DDW2Z9PAHPXE7', 'ANTA', NULL, NULL, 'Pucuk', NULL, '2018-08-13 16:56:00', 'FRM-201808-09', 9, '', 1, 1, '2018-08-13 16:56:48', 1, '2018-08-13 09:56:59');

-- --------------------------------------------------------

--
-- Table structure for table `frm_journal_detail`
--

CREATE TABLE IF NOT EXISTS `frm_journal_detail` (
  `id_frm_journal_detail` int(11) NOT NULL,
  `id_frm_journal` int(11) DEFAULT NULL,
  `id_frm_account` varchar(20) DEFAULT NULL,
  `id_frm_journal_period` varchar(20) DEFAULT NULL,
  `pos` tinyint(1) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `frm_journal_detail`
--

INSERT INTO `frm_journal_detail` (`id_frm_journal_detail`, `id_frm_journal`, `id_frm_account`, `id_frm_journal_period`, `pos`, `nominal`, `note`, `create_by_users`, `create_date`, `update_by_users`, `update_date`) VALUES
(2, 1, 'ANTA1 1 01 01 0001', 'DDW2Z9PAHPXE7', 2, -700000, NULL, 1, '2018-08-13 16:12:38', NULL, '2018-08-13 09:12:38'),
(3, 1, 'ANTA1 1 02 01 0001', 'DDW2Z9PAHPXE7', 1, 700000, NULL, 1, '2018-08-13 16:12:50', NULL, '2018-08-13 09:12:50'),
(4, 2, 'ANTA1 1 02 01 0001', 'DDW2Z9PAHPXE7', 1, 700000, NULL, 1, '2018-08-13 16:33:30', NULL, '2018-08-13 09:33:30'),
(5, 3, 'ANTA1 1 02 01 0001', 'DDW2Z9PAHPXE7', 1, 700000, NULL, 1, '2018-08-13 16:34:34', NULL, '2018-08-13 09:34:34'),
(6, 4, 'ANTA1 1 01 01 0001', 'DDW2Z9PAHPXE7', 2, -700000, NULL, 1, '2018-08-13 16:34:43', NULL, '2018-08-13 09:34:43'),
(7, 5, 'ANTA1 1 02 01 0001', 'DDW2Z9PAHPXE7', 1, 700000, NULL, 1, '2018-08-13 16:42:48', NULL, '2018-08-13 09:42:48'),
(8, 5, 'ANTA1 1 01 01 0001', 'DDW2Z9PAHPXE7', 2, -700000, NULL, 1, '2018-08-13 16:42:52', NULL, '2018-08-13 09:42:52'),
(9, 6, 'ANTA1 1 01 01 0001', 'DDW2Z9PAHPXE7', 1, 700000, NULL, 1, '2018-08-13 16:45:46', NULL, '2018-08-13 09:45:46'),
(10, 6, 'ANTA1 1 02 01 0001', 'DDW2Z9PAHPXE7', 2, -700000, NULL, 1, '2018-08-13 16:45:51', NULL, '2018-08-13 09:45:51'),
(11, 7, 'ANTA1 1 01 01 0001', 'DDW2Z9PAHPXE7', 2, -300000, NULL, 1, '2018-08-13 16:48:05', NULL, '2018-08-13 09:48:05'),
(12, 7, 'ANTA1 1 02 01 0001', 'DDW2Z9PAHPXE7', 2, -300000, NULL, 1, '2018-08-13 16:48:09', NULL, '2018-08-13 09:48:09'),
(13, 7, 'ANTA1 1 02 01 0001', 'DDW2Z9PAHPXE7', 1, 300000, NULL, 1, '2018-08-13 16:48:19', NULL, '2018-08-13 09:48:19'),
(14, 7, 'ANTA1 1 01 01 0001', 'DDW2Z9PAHPXE7', 1, 300000, NULL, 1, '2018-08-13 16:48:25', NULL, '2018-08-13 09:48:25'),
(15, 8, 'ANTA1 1 01 01 0001', 'DDW2Z9PAHPXE7', 1, 200000, NULL, 1, '2018-08-13 16:49:49', NULL, '2018-08-13 09:49:49'),
(16, 8, 'ANTA1 1 02 01 0001', 'DDW2Z9PAHPXE7', 2, -200000, NULL, 1, '2018-08-13 16:49:53', NULL, '2018-08-13 09:49:53'),
(17, 9, 'ANTA1 1 01 01 0001', 'DDW2Z9PAHPXE7', 2, -1, NULL, 1, '2018-08-13 16:56:48', NULL, '2018-08-13 09:56:48'),
(18, 9, 'ANTA1 1 02 01 0001', 'DDW2Z9PAHPXE7', 1, 1, NULL, 1, '2018-08-13 16:56:52', NULL, '2018-08-13 09:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `frm_journal_period`
--

CREATE TABLE IF NOT EXISTS `frm_journal_period` (
  `id_frm_journal_period` varchar(20) NOT NULL DEFAULT '',
  `code_users` varchar(200) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `bulan` tinyint(2) DEFAULT NULL,
  `tahun` int(5) DEFAULT NULL,
  `note` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `frm_journal_period`
--

INSERT INTO `frm_journal_period` (`id_frm_journal_period`, `code_users`, `title`, `code`, `startdate`, `enddate`, `bulan`, `tahun`, `note`, `status`, `create_by_users`, `create_date`, `update_by_users`, `update_date`) VALUES
('DDW2Z9PAHPXE7', 'ANTA', 'Awal Agustus 2018', '201808', '2018-08-01 00:00:00', '2018-08-31 23:59:59', 8, 2018, NULL, 1, 1, '2018-08-10 16:43:38', NULL, '2018-08-10 09:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `m_controller`
--

CREATE TABLE IF NOT EXISTS `m_controller` (
  `id_controller` int(11) NOT NULL,
  `id_module` int(11) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_form`
--

CREATE TABLE IF NOT EXISTS `m_form` (
  `id_form` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `nicename` varchar(40) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_menu`
--

CREATE TABLE IF NOT EXISTS `m_menu` (
  `id_menu` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `id_menu_kategori` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_menu`
--

INSERT INTO `m_menu` (`id_menu`, `name`, `parent`, `sort`, `link`, `id_menu_kategori`, `icon`, `create_by_users`, `create_date`, `update_by_users`, `update_date`) VALUES
(1, 'Configuration', NULL, 1, '', NULL, 'fa-wrench', 1, '2018-08-07 15:55:51', 1, '2018-08-07 08:55:51'),
(2, 'Menu', 1, 1, 'menu', NULL, 'fa-indent', 1, '2018-08-07 16:02:45', 1, '2018-08-07 09:02:45'),
(3, 'Users', 1, 2, '', NULL, 'fa-users', 1, '2018-08-07 16:03:16', 1, '2018-08-07 09:03:16'),
(4, 'Session User', 3, 1, 'users/users-settings/session-users', NULL, 'fa-user-secret', 1, '2018-08-07 16:04:41', 1, '2018-08-07 09:04:41'),
(5, 'Users', 3, 2, 'users', NULL, 'fa-users', 1, '2018-08-07 16:04:57', 1, '2018-08-07 09:04:57'),
(6, 'Settings', 1, 3, '', NULL, 'fa-gears', 1, '2018-08-07 16:05:44', 1, '2018-08-07 09:05:44'),
(7, 'Modules', 6, 1, 'settings/modules', NULL, 'fa-book', 1, '2018-08-07 16:06:17', 1, '2018-08-07 09:06:17'),
(8, 'Notifications', 6, 2, 'settings/notifications', NULL, 'fa-sticky-note', 1, '2018-08-07 16:07:07', 1, '2018-08-07 09:07:07'),
(9, 'Privileges', 1, 4, '', NULL, 'fa-unlock-alt', 1, '2018-08-07 16:07:45', 1, '2018-08-07 09:07:45'),
(10, 'Privilege', 9, 1, 'privilege', NULL, 'fa-unlock-alt', 1, '2018-08-07 16:08:14', 1, '2018-08-07 09:08:14'),
(11, 'Session Privilege', 9, 2, 'privilege/session', NULL, 'fa-unlock', 1, '2018-08-07 16:08:52', 1, '2018-08-07 09:08:52'),
(12, 'Privilege Khusus', 9, 3, 'settings/form', NULL, 'fa-ticket', 1, '2018-08-07 16:09:33', 1, '2018-08-07 09:09:33'),
(13, 'SCM', NULL, 100, '', NULL, 'fa-truck', 1, '2018-08-07 16:10:19', 1, '2018-08-07 09:10:19'),
(14, 'CRM', NULL, 200, '', NULL, 'fa-thumbs-o-up', 1, '2018-08-07 16:11:15', 1, '2018-08-07 09:11:15'),
(15, 'FRM', NULL, 300, '', NULL, 'fa-money', 1, '2018-08-07 16:12:05', 1, '2018-08-07 09:12:05'),
(16, 'SCM Master', 13, 1, '', NULL, 'fa-book', 1, '2018-08-07 16:12:52', 1, '2018-08-07 09:12:52'),
(17, 'SCM Settings', 13, 2, '', NULL, 'fa-gears', 1, '2018-08-07 16:13:06', 1, '2018-08-07 09:13:06'),
(18, 'CRM Master', 14, 1, '', NULL, 'fa-book', 1, '2018-08-07 16:13:33', 1, '2018-08-07 09:13:33'),
(19, 'CRM Settings', 14, 2, '', NULL, 'fa-gears', 1, '2018-08-07 16:13:45', 1, '2018-08-07 09:13:45'),
(20, 'FRM Master', 15, 1, '', NULL, 'fa-book', 1, '2018-08-07 16:14:00', 1, '2018-08-07 09:14:00'),
(21, 'FRM Settings', 15, 2, '', NULL, 'fa-gears', 1, '2018-08-07 16:14:13', 1, '2018-08-07 09:14:13'),
(22, 'COA', 20, 1, 'frm/frm-master/coa', NULL, 'fa-map-signs', 1, '2018-08-07 16:22:17', 1, '2018-08-07 09:22:17'),
(23, 'Siklus Akuntansi', 15, 3, '', NULL, 'fa-recycle', 1, '2018-08-07 16:24:26', 1, '2018-08-07 09:24:26'),
(24, 'Jurnal Transaksi', 23, 1, 'frm/frm-siklus/transaksi', NULL, 'fa-tags', 1, '2018-08-07 16:26:25', 1, '2018-08-07 09:26:25'),
(25, 'Buku Besar', 23, 2, 'frm/frm-siklus/buku-besar', NULL, 'fa-book', 1, '2018-08-07 16:27:02', 1, '2018-08-07 09:27:02'),
(26, 'Neraca Saldo', 23, 3, 'frm/frm-siklus/neraca-saldo', NULL, 'fa-fax', 1, '2018-08-07 16:29:03', 1, '2018-08-07 09:29:03'),
(27, 'Jurnal Penyesuaian', 23, 4, 'frm/frm-siklus/penyesuaian', NULL, 'fa-flag-o', 1, '2018-08-07 16:29:42', 1, '2018-08-07 09:29:42'),
(28, 'Neraca Lajur', 23, 5, 'frm/frm-siklus/neraca-lajur', NULL, 'fa-fax', 1, '2018-08-07 16:30:15', 1, '2018-08-07 09:30:15'),
(29, 'Laporan Keuangan', 23, 6, 'frm/frm-siklus/laporan-keuangan', NULL, 'fa-fax', 1, '2018-08-07 16:30:53', 1, '2018-08-07 09:30:53'),
(30, 'Jurnal Penutup', 23, 7, 'frm/frm-siklus/penutup', NULL, 'fa-folder', 1, '2018-08-07 16:31:49', 1, '2018-08-07 09:31:49'),
(31, 'Jurnal Pembalik', 23, 8, 'frm/frm-siklus/pembalik', NULL, 'fa-hand-paper-o', 1, '2018-08-07 16:32:26', 1, '2018-08-07 09:32:26'),
(32, 'Neraca Akhir', 23, 9, 'frm/frm-siklus/neraca-akhir', NULL, 'fa-calculator', 1, '2018-08-07 16:33:21', 1, '2018-08-07 09:33:21'),
(33, 'FRM Period', 20, 2, 'frm/frm-master/period', NULL, 'fa-object-group', 1, '2018-08-07 16:40:45', 1, '2018-08-07 09:40:45'),
(36, 'Session Group', 3, 3, 'users/users-settings/session-group', NULL, 'fa-user-secret', 1, '2018-08-10 16:19:19', 1, '2018-08-10 09:19:19'),
(35, 'Group', 3, 4, 'users/users-settings/approval-users', NULL, 'fa-group', 1, '2018-08-10 14:42:34', 1, '2018-08-10 07:42:34');

-- --------------------------------------------------------

--
-- Table structure for table `m_module`
--

CREATE TABLE IF NOT EXISTS `m_module` (
  `id_module` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `desc` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `update` int(11) DEFAULT NULL,
  `versi` varchar(100) NOT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_page`
--

CREATE TABLE IF NOT EXISTS `m_page` (
  `id_page` int(11) NOT NULL,
  `id_controller` int(11) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_privilege`
--

CREATE TABLE IF NOT EXISTS `m_privilege` (
  `id_privilege` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `dashbord` varchar(100) DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(1) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL COMMENT '1 => middle system, 2 => BTC, 3 => API BTC',
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_users`
--

CREATE TABLE IF NOT EXISTS `m_users` (
  `id_users` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `pass` varchar(90) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `id_privilege` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1 => middle system, 2 => BTC, 3 => API BTC',
  `status` tinyint(1) DEFAULT '2' COMMENT '1 => aktif, 2 => draft',
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `signature` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_users`
--

INSERT INTO `m_users` (`id_users`, `name`, `pass`, `email`, `id_privilege`, `type`, `status`, `create_by_users`, `create_date`, `update_by_users`, `update_date`, `signature`) VALUES
(1, 'admin', 'V8cF2S2jp5c3LdSCizKKsVCxD2nhdM80DS2esuIOXw890y4o6ikzPfcPT8YRQNdV2MtArp/pBq+hiULv5U0E8g==', 'itdev@antavaya.com', NULL, NULL, 1, NULL, NULL, NULL, '2015-06-28 01:54:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_users_group`
--

CREATE TABLE IF NOT EXISTS `m_users_group` (
  `id_m_users_group` varchar(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_users_group`
--

INSERT INTO `m_users_group` (`id_m_users_group`, `title`, `code`, `status`, `create_by_users`, `create_date`, `update_by_users`, `update_date`) VALUES
('6SOQAEPDBKXLQEY', 'ANTA-IT', 'ANTA', 1, 1, '2018-08-10 15:50:15', 1, '2018-08-10 08:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `m_users_group_approval`
--

CREATE TABLE IF NOT EXISTS `m_users_group_approval` (
  `id_m_users_group_approval` varchar(20) NOT NULL,
  `id_m_users_group` varchar(20) DEFAULT NULL,
  `id_users` int(11) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `m_users_group_teams`
--

CREATE TABLE IF NOT EXISTS `m_users_group_teams` (
  `id_m_users_group_teams` varchar(20) NOT NULL,
  `id_m_users_group` varchar(20) DEFAULT NULL,
  `id_users` varchar(20) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `patern`
--

CREATE TABLE IF NOT EXISTS `patern` (
  `id_patern` int(11) NOT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `title` varchar(200) DEFAULT NULL,
  `table` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scm_satuan`
--

CREATE TABLE IF NOT EXISTS `scm_satuan` (
  `id_scm_satuan` varchar(20) NOT NULL,
  `id_scm_satuan_group` varchar(20) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `level` tinyint(3) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scm_satuan_group`
--

CREATE TABLE IF NOT EXISTS `scm_satuan_group` (
  `id_scm_satuan_group` varchar(20) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings_notifications`
--

CREATE TABLE IF NOT EXISTS `settings_notifications` (
  `id_settings_notifications` varchar(20) NOT NULL,
  `id_users` int(11) DEFAULT NULL,
  `source_table` varchar(200) DEFAULT NULL,
  `source_id` varchar(20) DEFAULT NULL,
  `code` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `link` varchar(200) DEFAULT NULL,
  `link_check` varchar(200) DEFAULT NULL,
  `link_times` varchar(200) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id_api_keys`);

--
-- Indexes for table `api_users`
--
ALTER TABLE `api_users`
  ADD PRIMARY KEY (`id_api_users`);

--
-- Indexes for table `bridge`
--
ALTER TABLE `bridge`
  ADD PRIMARY KEY (`id_bridge`);

--
-- Indexes for table `bridge_users`
--
ALTER TABLE `bridge_users`
  ADD PRIMARY KEY (`id_bridge_users`);

--
-- Indexes for table `cms_article`
--
ALTER TABLE `cms_article`
  ADD PRIMARY KEY (`id_cms_article`);

--
-- Indexes for table `cms_banner_promo`
--
ALTER TABLE `cms_banner_promo`
  ADD PRIMARY KEY (`id_cms_banner_promo`);

--
-- Indexes for table `cms_comment`
--
ALTER TABLE `cms_comment`
  ADD PRIMARY KEY (`id_cms_comment`);

--
-- Indexes for table `cms_gallery`
--
ALTER TABLE `cms_gallery`
  ADD PRIMARY KEY (`id_cms_gallery`);

--
-- Indexes for table `cms_page`
--
ALTER TABLE `cms_page`
  ADD PRIMARY KEY (`id_cms_page`);

--
-- Indexes for table `cms_service`
--
ALTER TABLE `cms_service`
  ADD PRIMARY KEY (`id_cms_service`);

--
-- Indexes for table `crm_agent`
--
ALTER TABLE `crm_agent`
  ADD PRIMARY KEY (`id_crm_agent`);

--
-- Indexes for table `crm_agent_store`
--
ALTER TABLE `crm_agent_store`
  ADD PRIMARY KEY (`id_crm_agent_store`);

--
-- Indexes for table `crm_customer`
--
ALTER TABLE `crm_customer`
  ADD PRIMARY KEY (`id_crm_customer`);

--
-- Indexes for table `crm_customer_company`
--
ALTER TABLE `crm_customer_company`
  ADD PRIMARY KEY (`id_crm_customer_company`);

--
-- Indexes for table `crm_customer_company_credit`
--
ALTER TABLE `crm_customer_company_credit`
  ADD PRIMARY KEY (`id_crm_customer_company_credit`);

--
-- Indexes for table `crm_customer_company_credit_log`
--
ALTER TABLE `crm_customer_company_credit_log`
  ADD PRIMARY KEY (`id_crm_customer_company_credit_log`);

--
-- Indexes for table `crm_customer_company_deposit`
--
ALTER TABLE `crm_customer_company_deposit`
  ADD PRIMARY KEY (`id_crm_customer_company_deposit`);

--
-- Indexes for table `crm_customer_company_deposit_log`
--
ALTER TABLE `crm_customer_company_deposit_log`
  ADD PRIMARY KEY (`id_crm_customer_company_deposit_log`);

--
-- Indexes for table `crm_customer_company_discount`
--
ALTER TABLE `crm_customer_company_discount`
  ADD PRIMARY KEY (`id_crm_customer_company_discount`);

--
-- Indexes for table `crm_customer_deposit`
--
ALTER TABLE `crm_customer_deposit`
  ADD PRIMARY KEY (`id_crm_customer_deposit`);

--
-- Indexes for table `crm_customer_deposit_log`
--
ALTER TABLE `crm_customer_deposit_log`
  ADD PRIMARY KEY (`id_crm_customer_deposit_log`);

--
-- Indexes for table `crm_customer_users_deposit`
--
ALTER TABLE `crm_customer_users_deposit`
  ADD PRIMARY KEY (`id_crm_customer_users_deposit`);

--
-- Indexes for table `crm_customer_users_deposit_log`
--
ALTER TABLE `crm_customer_users_deposit_log`
  ADD PRIMARY KEY (`id_crm_customer_users_deposit_log`);

--
-- Indexes for table `crm_pos_approval_privilege`
--
ALTER TABLE `crm_pos_approval_privilege`
  ADD PRIMARY KEY (`id_crm_pos_approval_privilege`);

--
-- Indexes for table `crm_pos_approval_settings`
--
ALTER TABLE `crm_pos_approval_settings`
  ADD PRIMARY KEY (`id_crm_pos_approval_settings`);

--
-- Indexes for table `crm_pos_discount`
--
ALTER TABLE `crm_pos_discount`
  ADD PRIMARY KEY (`id_crm_pos_discount`);

--
-- Indexes for table `crm_pos_discount_company`
--
ALTER TABLE `crm_pos_discount_company`
  ADD PRIMARY KEY (`id_crm_pos_discount_company`);

--
-- Indexes for table `crm_pos_discount_merchandise`
--
ALTER TABLE `crm_pos_discount_merchandise`
  ADD PRIMARY KEY (`id_crm_pos_discount_merchandise`);

--
-- Indexes for table `crm_pos_discount_payment_channel`
--
ALTER TABLE `crm_pos_discount_payment_channel`
  ADD PRIMARY KEY (`id_crm_pos_discount_payment_channel`);

--
-- Indexes for table `crm_pos_discount_set`
--
ALTER TABLE `crm_pos_discount_set`
  ADD PRIMARY KEY (`id_crm_pos_discount_set`);

--
-- Indexes for table `crm_pos_discount_voucher`
--
ALTER TABLE `crm_pos_discount_voucher`
  ADD PRIMARY KEY (`id_crm_pos_discount_voucher`);

--
-- Indexes for table `crm_pos_discount_voucher_use`
--
ALTER TABLE `crm_pos_discount_voucher_use`
  ADD PRIMARY KEY (`id_crm_pos_discount_voucher_use`);

--
-- Indexes for table `crm_pos_location`
--
ALTER TABLE `crm_pos_location`
  ADD PRIMARY KEY (`id_crm_pos_location`);

--
-- Indexes for table `crm_pos_location_dc`
--
ALTER TABLE `crm_pos_location_dc`
  ADD PRIMARY KEY (`id_crm_pos_location_dc`);

--
-- Indexes for table `crm_pos_order`
--
ALTER TABLE `crm_pos_order`
  ADD PRIMARY KEY (`id_crm_pos_order`);

--
-- Indexes for table `crm_pos_order_cashback`
--
ALTER TABLE `crm_pos_order_cashback`
  ADD PRIMARY KEY (`id_crm_pos_order_cashback`);

--
-- Indexes for table `crm_pos_order_charge`
--
ALTER TABLE `crm_pos_order_charge`
  ADD PRIMARY KEY (`id_crm_pos_order_charge`);

--
-- Indexes for table `crm_pos_order_discount`
--
ALTER TABLE `crm_pos_order_discount`
  ADD PRIMARY KEY (`id_crm_pos_order_discount`);

--
-- Indexes for table `crm_pos_order_discount_cashback`
--
ALTER TABLE `crm_pos_order_discount_cashback`
  ADD PRIMARY KEY (`id_crm_pos_order_discount_cashback`);

--
-- Indexes for table `crm_pos_order_merchandise`
--
ALTER TABLE `crm_pos_order_merchandise`
  ADD PRIMARY KEY (`id_crm_pos_order_merchandise`);

--
-- Indexes for table `crm_pos_order_merchandise_addon`
--
ALTER TABLE `crm_pos_order_merchandise_addon`
  ADD PRIMARY KEY (`id_crm_pos_order_merchandise_addon`);

--
-- Indexes for table `crm_pos_order_merchandise_discount`
--
ALTER TABLE `crm_pos_order_merchandise_discount`
  ADD PRIMARY KEY (`id_crm_pos_order_merchandise_discount`);

--
-- Indexes for table `crm_pos_order_merchandise_discount_cashback`
--
ALTER TABLE `crm_pos_order_merchandise_discount_cashback`
  ADD PRIMARY KEY (`id_crm_pos_order_merchandise_discount_cashback`);

--
-- Indexes for table `crm_pos_products`
--
ALTER TABLE `crm_pos_products`
  ADD PRIMARY KEY (`id_crm_pos_products`);

--
-- Indexes for table `crm_pos_products_categories`
--
ALTER TABLE `crm_pos_products_categories`
  ADD PRIMARY KEY (`id_crm_pos_products_categories`);

--
-- Indexes for table `crm_pos_products_file`
--
ALTER TABLE `crm_pos_products_file`
  ADD PRIMARY KEY (`id_crm_pos_products_file`);

--
-- Indexes for table `crm_pos_products_merchandise`
--
ALTER TABLE `crm_pos_products_merchandise`
  ADD PRIMARY KEY (`id_crm_pos_products_merchandise`);

--
-- Indexes for table `crm_pos_products_merchandise_classification`
--
ALTER TABLE `crm_pos_products_merchandise_classification`
  ADD PRIMARY KEY (`id_crm_pos_products_merchandise_classification`);

--
-- Indexes for table `crm_pos_products_specification`
--
ALTER TABLE `crm_pos_products_specification`
  ADD PRIMARY KEY (`id_crm_pos_products_specification`);

--
-- Indexes for table `crm_pos_products_specification_data`
--
ALTER TABLE `crm_pos_products_specification_data`
  ADD PRIMARY KEY (`id_crm_pos_products_specification_data`);

--
-- Indexes for table `crm_pos_products_specification_details`
--
ALTER TABLE `crm_pos_products_specification_details`
  ADD PRIMARY KEY (`id_crm_pos_products_specification_details`);

--
-- Indexes for table `crm_pos_products_tags`
--
ALTER TABLE `crm_pos_products_tags`
  ADD PRIMARY KEY (`id_crm_pos_products_tags`);

--
-- Indexes for table `crm_pos_quotation`
--
ALTER TABLE `crm_pos_quotation`
  ADD PRIMARY KEY (`id_crm_pos_quotation`);

--
-- Indexes for table `crm_pos_quotation_cashback`
--
ALTER TABLE `crm_pos_quotation_cashback`
  ADD PRIMARY KEY (`id_crm_pos_quotation_cashback`);

--
-- Indexes for table `crm_pos_quotation_discount`
--
ALTER TABLE `crm_pos_quotation_discount`
  ADD PRIMARY KEY (`id_crm_pos_quotation_discount`);

--
-- Indexes for table `crm_pos_quotation_merchandise`
--
ALTER TABLE `crm_pos_quotation_merchandise`
  ADD PRIMARY KEY (`id_crm_pos_quotation_merchandise`);

--
-- Indexes for table `crm_pos_quotation_merchandise_addon`
--
ALTER TABLE `crm_pos_quotation_merchandise_addon`
  ADD PRIMARY KEY (`id_crm_pos_quotation_merchandise_addon`);

--
-- Indexes for table `crm_pos_quotation_merchandise_discount`
--
ALTER TABLE `crm_pos_quotation_merchandise_discount`
  ADD PRIMARY KEY (`id_crm_pos_quotation_merchandise_discount`);

--
-- Indexes for table `crm_pos_request`
--
ALTER TABLE `crm_pos_request`
  ADD PRIMARY KEY (`id_crm_pos_request`);

--
-- Indexes for table `crm_pos_request_merchandise`
--
ALTER TABLE `crm_pos_request_merchandise`
  ADD PRIMARY KEY (`id_crm_pos_request_merchandise`);

--
-- Indexes for table `d_privilege_form`
--
ALTER TABLE `d_privilege_form`
  ADD PRIMARY KEY (`id_privilege_form`);

--
-- Indexes for table `d_privilege_menu`
--
ALTER TABLE `d_privilege_menu`
  ADD PRIMARY KEY (`id_privilege_menu`);

--
-- Indexes for table `d_privilege_module`
--
ALTER TABLE `d_privilege_module`
  ADD PRIMARY KEY (`id_privilege_module`);

--
-- Indexes for table `d_privilege_page`
--
ALTER TABLE `d_privilege_page`
  ADD PRIMARY KEY (`id_privilege_page`);

--
-- Indexes for table `d_session`
--
ALTER TABLE `d_session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `frm_account`
--
ALTER TABLE `frm_account`
  ADD PRIMARY KEY (`id_frm_account`);

--
-- Indexes for table `frm_journal`
--
ALTER TABLE `frm_journal`
  ADD PRIMARY KEY (`id_frm_journal`);

--
-- Indexes for table `frm_journal_detail`
--
ALTER TABLE `frm_journal_detail`
  ADD PRIMARY KEY (`id_frm_journal_detail`);

--
-- Indexes for table `frm_journal_period`
--
ALTER TABLE `frm_journal_period`
  ADD PRIMARY KEY (`id_frm_journal_period`);

--
-- Indexes for table `m_controller`
--
ALTER TABLE `m_controller`
  ADD PRIMARY KEY (`id_controller`);

--
-- Indexes for table `m_form`
--
ALTER TABLE `m_form`
  ADD PRIMARY KEY (`id_form`);

--
-- Indexes for table `m_menu`
--
ALTER TABLE `m_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `m_module`
--
ALTER TABLE `m_module`
  ADD PRIMARY KEY (`id_module`);

--
-- Indexes for table `m_page`
--
ALTER TABLE `m_page`
  ADD PRIMARY KEY (`id_page`);

--
-- Indexes for table `m_privilege`
--
ALTER TABLE `m_privilege`
  ADD PRIMARY KEY (`id_privilege`);

--
-- Indexes for table `m_users`
--
ALTER TABLE `m_users`
  ADD PRIMARY KEY (`id_users`);

--
-- Indexes for table `m_users_group`
--
ALTER TABLE `m_users_group`
  ADD PRIMARY KEY (`id_m_users_group`);

--
-- Indexes for table `m_users_group_approval`
--
ALTER TABLE `m_users_group_approval`
  ADD PRIMARY KEY (`id_m_users_group_approval`);

--
-- Indexes for table `m_users_group_teams`
--
ALTER TABLE `m_users_group_teams`
  ADD PRIMARY KEY (`id_m_users_group_teams`);

--
-- Indexes for table `patern`
--
ALTER TABLE `patern`
  ADD PRIMARY KEY (`id_patern`);

--
-- Indexes for table `scm_satuan`
--
ALTER TABLE `scm_satuan`
  ADD PRIMARY KEY (`id_scm_satuan`);

--
-- Indexes for table `scm_satuan_group`
--
ALTER TABLE `scm_satuan_group`
  ADD PRIMARY KEY (`id_scm_satuan_group`);

--
-- Indexes for table `settings_notifications`
--
ALTER TABLE `settings_notifications`
  ADD PRIMARY KEY (`id_settings_notifications`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_customer_company`
--
ALTER TABLE `crm_customer_company`
  MODIFY `id_crm_customer_company` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crm_pos_discount_company`
--
ALTER TABLE `crm_pos_discount_company`
  MODIFY `id_crm_pos_discount_company` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `d_privilege_form`
--
ALTER TABLE `d_privilege_form`
  MODIFY `id_privilege_form` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `d_privilege_menu`
--
ALTER TABLE `d_privilege_menu`
  MODIFY `id_privilege_menu` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `d_privilege_module`
--
ALTER TABLE `d_privilege_module`
  MODIFY `id_privilege_module` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `d_privilege_page`
--
ALTER TABLE `d_privilege_page`
  MODIFY `id_privilege_page` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frm_journal`
--
ALTER TABLE `frm_journal`
  MODIFY `id_frm_journal` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `frm_journal_detail`
--
ALTER TABLE `frm_journal_detail`
  MODIFY `id_frm_journal_detail` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `m_controller`
--
ALTER TABLE `m_controller`
  MODIFY `id_controller` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_form`
--
ALTER TABLE `m_form`
  MODIFY `id_form` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_menu`
--
ALTER TABLE `m_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `m_module`
--
ALTER TABLE `m_module`
  MODIFY `id_module` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_page`
--
ALTER TABLE `m_page`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_privilege`
--
ALTER TABLE `m_privilege`
  MODIFY `id_privilege` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `m_users`
--
ALTER TABLE `m_users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `patern`
--
ALTER TABLE `patern`
  MODIFY `id_patern` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
