<?php

/*
 * The MIT License
 *
 * Copyright (c) 2010 Johannes Mueller <circus2(at)web.de>
 * Copyright (c) 2012-2024 Toha <tohenk@yahoo.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace MwbExporter\Formatter\Zend\DbTable;

use MwbExporter\Configuration\Indentation as IndentationConfiguration;
use MwbExporter\Configuration\Filename as FilenameConfiguration;
use MwbExporter\Formatter\Zend\Configuration\TableParent as TableParentConfiguration;
use MwbExporter\Formatter\Zend\Configuration\TablePrefix as TablePrefixConfiguration;
use MwbExporter\Formatter\Zend\DbTable\Configuration\DRI as DRIConfiguration;
use MwbExporter\Formatter\Zend\DbTable\Configuration\GetterSetter as GetterSetterConfiguration;
use MwbExporter\Formatter\Zend\Formatter as BaseFormatter;
use MwbExporter\Model\Base;

class Formatter extends BaseFormatter
{
    protected function init()
    {
        parent::init();
        $this->getConfigurations()
            ->add(new DRIConfiguration())
            ->add(new GetterSetterConfiguration())
            ->merge([
                IndentationConfiguration::class => 4,
                FilenameConfiguration::class => 'DbTable/%schema%/%entity%.%extension%',
                TablePrefixConfiguration::class => 'Application_Model_DbTable_',
                // If you want to use your personnal Zend_Db_Table_Abstract,
                // you need to specifie here his name
                TableParentConfiguration::class => 'Zend_Db_Table_Abstract',
            ], true)
        ;
    }

    /**
     * (non-PHPdoc)
     * @see \MwbExporter\Formatter\Formatter::createDatatypeConverter()
     */
    protected function createDatatypeConverter()
    {
        return new DatatypeConverter();
    }

    /**
     * (non-PHPdoc)
     * @see \MwbExporter\Formatter\Formatter::createTable()
     */
    public function createTable(Base $parent, $node)
    {
        return new Model\Table($parent, $node);
    }

    /**
     * (non-PHPdoc)
     * @see \MwbExporter\Formatter\Formatter::createForeignKey()
     */
    public function createForeignKey(Base $parent, $node)
    {
        return new Model\ForeignKey($parent, $node);
    }

    public function getTitle()
    {
        return 'Zend DbTable';
    }

    public function getFileExtension()
    {
        return 'php';
    }

    /**
     * Get configuration scope.
     *
     * @return string
     */
    public static function getScope()
    {
        return 'Zend DbTable';
    }
}
