<?php

/*
 * The MIT License
 *
 * Copyright (c) 2012 Allan Sun <sunajia@gmail.com>
 * Copyright (c) 2012-2025 Toha <tohenk@yahoo.com>
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

namespace MwbExporter\Formatter\Zend\RestController;

use MwbExporter\Configuration\Indentation as IndentationConfiguration;
use MwbExporter\Formatter\Zend\Configuration\TableParent as TableParentConfiguration;
use MwbExporter\Formatter\Zend\Configuration\TablePrefix as TablePrefixConfiguration;
use MwbExporter\Formatter\Zend\Formatter as BaseFormatter;
use MwbExporter\Model\Base;

class Formatter extends BaseFormatter
{
    protected function init()
    {
        parent::init();
        $this->getConfigurations()
            ->merge([
                IndentationConfiguration::class => 4,
                TablePrefixConfiguration::class => '',
                TableParentConfiguration::class => 'Zend_Rest_Controller',
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

    public function getTitle()
    {
        return 'Zend Rest Controller';
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
        return 'Zend Rest Controller';
    }
}
