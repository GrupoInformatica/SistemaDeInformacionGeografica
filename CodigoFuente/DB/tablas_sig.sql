
-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2013 at 04:19 PM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `a2897560_vendedo`
--

-- --------------------------------------------------------

--
-- Table structure for table `sig_evento`
--

DROP TABLE IF EXISTS `sig_evento`;
CREATE TABLE IF NOT EXISTS `sig_evento` (
  `codigoEvento` int(11) NOT NULL,
  `tituloEvento` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `fechaEvento` date NOT NULL,
  `codigoHora` int(11) NOT NULL,
  `descripcionEvento` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `codigoTipoEvento` int(11) NOT NULL,
  `latitud` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `longitud` varchar(11) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`codigoEvento`),
  FOREIGN KEY (`codigoHora`)
      REFERENCES `sig_hora`(`codigoHora`)
      ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (`codigoTipoEvento`)
      REFERENCES `sig_tipo_evento`(`codigoTipoEvento`)
      ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sig_hora`
--

DROP TABLE IF EXISTS `sig_hora`;
CREATE TABLE IF NOT EXISTS `sig_hora` (
  `codigoHora` int(11) NOT NULL,
  `descripcionHora` char(8) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`codigoHora`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sig_tipo_evento`
--

DROP TABLE IF EXISTS `sig_tipo_evento`;
CREATE TABLE IF NOT EXISTS `sig_tipo_evento` (
  `codigoTipoEvento` int(11) NOT NULL,
  `descripcionTipoEvento` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`codigoTipoEvento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sig_zona`
--

DROP TABLE IF EXISTS `sig_zona`;
CREATE TABLE IF NOT EXISTS `sig_zona` (
  `codigoZona` int(11) NOT NULL,
  `nombreZona` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `latitud` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `longitud` varchar(11) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`codigoZona`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
