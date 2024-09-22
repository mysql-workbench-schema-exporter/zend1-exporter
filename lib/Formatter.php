<?php

/*
 * The MIT License
 *
 * Copyright (c) 2012 Allan Sun <sunajia@gmail.com>
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

namespace MwbExporter\Formatter\Zend;

use MwbExporter\Formatter\Formatter as BaseFormatter;
use MwbExporter\Formatter\Zend\Configuration\TableParent as TableParentConfiguration;
use MwbExporter\Formatter\Zend\Configuration\TablePrefix as TablePrefixConfiguration;
use MwbExporter\Helper\Comment;

abstract class Formatter extends BaseFormatter
{
    protected function init()
    {
        parent::init();
        $this->getConfigurations()
            ->add(new TablePrefixConfiguration())
            ->add(new TableParentConfiguration())
        ;
        $this->commentFormat = Comment::FORMAT_PHP;
    }

    public function getVersion()
    {
        return 'dev';
    }

    public static function getDocDir()
    {
        return __DIR__.'/../docs';
    }

    /**
     * Get configuration scope.
     *
     * @return string
     */
    public static function getScope()
    {
        return 'Zend Global';
    }
}
