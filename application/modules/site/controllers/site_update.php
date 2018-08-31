<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_update extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
    $this->load->model('settings/m_settings');
  }
  
  /**
   * @author NBS
   * @abstract Create v1
   */
  function v1(){
    $v = "v1";
    $title = "site";
    
    $query = <<<EOD
      -- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2017 at 03:46 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `crm_customer`
--

CREATE TABLE IF NOT EXISTS `crm_customer` (
  `id_crm_customer` varchar(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telp` varchar(100) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_travel_bandara`
--

CREATE TABLE IF NOT EXISTS `site_travel_bandara` (
  `id_site_travel_bandara` varchar(20) NOT NULL,
  `AirportCode` varchar(3) DEFAULT NULL,
  `AirportName` varchar(50) DEFAULT NULL,
  `AirportKeyword` text,
  `AirportCountry` varchar(100) DEFAULT NULL,
  `AirportCity` varchar(100) DEFAULT NULL,
  `AirportAddress` text,
  `AirportDescription` text,
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_travel_book`
--

CREATE TABLE IF NOT EXISTS `site_travel_book` (
  `id_site_travel_book` varchar(20) NOT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `pnrid` varchar(50) DEFAULT NULL,
  `departure` varchar(3) DEFAULT NULL,
  `arrival` varchar(3) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `departuredate` date DEFAULT NULL,
  `returndate` date DEFAULT NULL,
  `adult` tinyint(1) DEFAULT NULL,
  `child` tinyint(1) DEFAULT NULL,
  `infant` tinyint(1) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1 => one way, 2 => round trip',
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_travel_book_flight`
--

CREATE TABLE IF NOT EXISTS `site_travel_book_flight` (
  `id_site_travel_book_flight` varchar(20) NOT NULL,
  `id_site_travel_book` varchar(20) DEFAULT NULL,
  `departure` varchar(3) DEFAULT NULL,
  `arrival` varchar(3) DEFAULT NULL,
  `departuredate` datetime DEFAULT NULL,
  `arrivaldate` datetime DEFAULT NULL,
  `seat` tinyint(1) DEFAULT NULL,
  `sort` tinyint(1) DEFAULT NULL,
  `flightnumber` int(11) DEFAULT NULL,
  `flightclass` varchar(1) DEFAULT NULL,
  `airline` varchar(2) DEFAULT NULL,
  `airlinegroup` tinyint(1) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `rincian` text,
  `type` tinyint(1) DEFAULT NULL COMMENT '1 => one way, 2 => round trip',
  `status` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_travel_book_passangers`
--

CREATE TABLE IF NOT EXISTS `site_travel_book_passangers` (
  `id_site_travel_book_passangers` varchar(20) NOT NULL,
  `id_site_travel_passangers` varchar(20) DEFAULT NULL,
  `id_site_travel_book` varchar(20) DEFAULT NULL,
  `title` tinyint(1) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `assoc` tinyint(1) DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_travel_book_pay`
--

CREATE TABLE IF NOT EXISTS `site_travel_book_pay` (
  `id_site_travel_book_pay` varchar(20) NOT NULL,
  `id_site_travel_book` varchar(20) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `potongan` double DEFAULT NULL,
  `tambahan` double DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `terima` double DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_travel_passangers`
--

CREATE TABLE IF NOT EXISTS `site_travel_passangers` (
  `id_site_travel_passangers` varchar(20) NOT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `title` tinyint(1) DEFAULT NULL COMMENT '1 => Tuan, 2 => Nyonya, 3 => Nona',
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1 => adult, 2 => child, 3 => infant',
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_customer`
--
ALTER TABLE `crm_customer`
  ADD PRIMARY KEY (`id_crm_customer`);

--
-- Indexes for table `site_travel_bandara`
--
ALTER TABLE `site_travel_bandara`
  ADD PRIMARY KEY (`id_site_travel_bandara`);

--
-- Indexes for table `site_travel_book`
--
ALTER TABLE `site_travel_book`
  ADD PRIMARY KEY (`id_site_travel_book`);

--
-- Indexes for table `site_travel_book_flight`
--
ALTER TABLE `site_travel_book_flight`
  ADD PRIMARY KEY (`id_site_travel_book_flight`);

--
-- Indexes for table `site_travel_book_passangers`
--
ALTER TABLE `site_travel_book_passangers`
  ADD PRIMARY KEY (`id_site_travel_book_passangers`);

--
-- Indexes for table `site_travel_book_pay`
--
ALTER TABLE `site_travel_book_pay`
  ADD PRIMARY KEY (`id_site_travel_book_pay`);

--
-- Indexes for table `site_travel_passangers`
--
ALTER TABLE `site_travel_passangers`
  ADD PRIMARY KEY (`id_site_travel_passangers`);
EOD;
    $this->global_models->query($query);

//    wajib
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  function v2(){
    $v = "v2";
    $title = "site";
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `site_ticket_available_progress` (
  `id_site_ticket_available_progress` int(11) NOT NULL AUTO_INCREMENT,
  `scrapkey` varchar(200) DEFAULT NULL,
  `flightcount` int(11) DEFAULT NULL,
  `issuccess` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by_users` int(11) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_site_ticket_available_progress`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  function v3(){
    $v = "v3";
    $title = "site";
    $this->global_models->query("ALTER TABLE `site_ticket_available_progress` CHANGE `id_site_ticket_available_progress` `id_site_ticket_available_progress` VARCHAR(200) NOT NULL;");
    $this->global_models->query("ALTER TABLE `site_ticket_available_progress` CHANGE `update_by_users` `update_manual` DATETIME NULL DEFAULT NULL;");
    
    $this->global_models->update("m_module", array("name" => $title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($title);
    print $v;
    die;
  }
  
  var $title = "site";
  
  function v4(){
    $v = "v4";
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `site_ticket_reservation` (
  `id_site_ticket_reservation` varchar(20) NOT NULL,
  `id_crm_customer` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_manual` datetime DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_site_ticket_reservation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `site_ticket_reservation_flight` (
  `id_site_ticket_reservation_flight` varchar(20) NOT NULL,
  `id_site_ticket_reservation` varchar(20) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `origin` varchar(5) DEFAULT NULL,
  `destination` varchar(5) DEFAULT NULL,
  `flightnumber` varchar(20) DEFAULT NULL,
  `classcode` varchar(20) DEFAULT NULL,
  `airline` varchar(20) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `departdate` datetime DEFAULT NULL,
  `arrivaldate` datetime DEFAULT NULL,
  `urut` tinyint(1) DEFAULT NULL,
  `note` text,
  `price` double DEFAULT NULL,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_manual` datetime DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_site_ticket_reservation_flight`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("CREATE TABLE IF NOT EXISTS `site_ticket_reservation_pax` (
  `id_site_ticket_reservation_pax` varchar(20) NOT NULL,
  `id_site_ticket_reservation` varchar(20) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `title` tinyint(1) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telp_home` varchar(100) DEFAULT NULL,
  `telp_1` varchar(100) DEFAULT NULL,
  `telp_2` varchar(100) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `passportexpire` date DEFAULT NULL,
  `passportnumber` varchar(100) DEFAULT NULL,
  `passportorigin` varchar(100) DEFAULT NULL,
  `urut` tinyint(1) DEFAULT NULL,
  `urut_assoc` tinyint(1) DEFAULT NULL,
  `note` text,
  `create_by_users` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_manual` datetime DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY `id_site_ticket_reservation_pax`
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    
    $this->global_models->query("ALTER TABLE `site_ticket_reservation_progress` ADD `id_site_ticket_reservation` VARCHAR(20) NULL AFTER `id_site_ticket_reservation_progress`, ADD `id_site_ticket_reservation_flight` VARCHAR(20) NULL AFTER `id_site_ticket_reservation`;");
    $this->global_models->query("ALTER TABLE `site_ticket_reservation_progress` ADD `status` TINYINT(1) NULL AFTER `note`;");
    
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v5(){
    $v = "v5";
    $this->global_models->query("ALTER TABLE `site_ticket_reservation_flight` ADD `id` VARCHAR(100) NULL AFTER `id_site_ticket_reservation`, ADD `pnrid` VARCHAR(10) NULL AFTER `id`, ADD `timelimit` DATETIME NULL AFTER `pnrid`;");
    $this->global_models->query("ALTER TABLE `site_ticket_reservation_pax` ADD `ticketnumber` VARCHAR(200) NULL AFTER `urut_assoc`;");
    $this->global_models->query("ALTER TABLE `site_ticket_reservation_flight` ADD `total` DOUBLE NULL AFTER `price`, ADD `nta` DOUBLE NULL AFTER `total`, ADD `detail` TEXT NULL AFTER `nta`;");
    
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
  
  function v6(){
    $v = "v6";
    $this->global_models->query("ALTER TABLE `site_ticket_reservation_flight` ADD `status` TINYINT(1) NULL DEFAULT '1' AFTER `detail`;");
    $this->global_models->query("ALTER TABLE `site_ticket_reservation_flight` ADD `seat` TINYINT(3) NULL AFTER `status`;");
    $this->global_models->query("ALTER TABLE `site_ticket_reservation` ADD `kirim1` TEXT NULL AFTER `note`, ADD `kirim2` TEXT NULL AFTER `kirim1`;");
    
    $this->global_models->update("m_module", array("name" => $this->title), array("versi" => $v, "update_by_users" => $this->session->userdata("id")));
    $this->m_settings->update_module($this->title);
    print $v;
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */