![Build Status](https://github.com/mysql-workbench-schema-exporter/zend1-exporter/actions/workflows/continuous-integration.yml/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/mysql-workbench-schema-exporter/zend1-exporter/v/stable.svg)](https://packagist.org/packages/mysql-workbench-schema-exporter/zend1-exporter)
[![Total Downloads](https://poser.pugx.org/mysql-workbench-schema-exporter/zend1-exporter/downloads.svg)](https://packagist.org/packages/mysql-workbench-schema-exporter/zend1-exporter) 
[![License](https://poser.pugx.org/mysql-workbench-schema-exporter/zend1-exporter/license.svg)](https://packagist.org/packages/mysql-workbench-schema-exporter/zend1-exporter)

# README

This is an exporter to convert [MySQL Workbench](http://www.mysql.com/products/workbench/) Models (\*.mwb) to Zend Framework 1 DbTable and RestController Schema.

## Prerequisites

  * PHP 7.2+
  * Composer to install the dependencies

## Installation

```
composer require --dev mysql-workbench-schema-exporter/zend1-exporter
```

This will install the exporter and also require [mysql-workbench-schema-exporter](https://github.com/mysql-workbench-schema-exporter/mysql-workbench-schema-exporter).

You then can invoke the CLI script using `vendor/bin/mysql-workbench-schema-export`.

## Configuration

  * [Zend DbTable](/docs/zend-dbtable.md)
  * [Zend Rest Controller](/docs/zend-restcontroller.md)

## Command Line Interface (CLI)

See documentation for [mysql-workbench-schema-exporter](https://github.com/mysql-workbench-schema-exporter/mysql-workbench-schema-exporter#command-line-interface-cli)

## Links

  * [MySQL Workbench](http://wb.mysql.com/)
  * [Zend Project](http://framework.zend.com/)
