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

namespace MwbExporter\Formatter\Zend\DbTable\Model;

use MwbExporter\Configuration\Comment as CommentConfiguration;
use MwbExporter\Configuration\Header as HeaderConfiguration;
use MwbExporter\Formatter\Zend\Configuration\TableParent as TableParentConfiguration;
use MwbExporter\Formatter\Zend\Configuration\TablePrefix as TablePrefixConfiguration;
use MwbExporter\Formatter\Zend\DbTable\Configuration\DRI as DRIConfiguration;
use MwbExporter\Model\Table as BaseTable;
use MwbExporter\Writer\WriterInterface;

class Table extends BaseTable
{
    public function getTablePrefix()
    {
        return $this->translateVars($this->getConfig(TablePrefixConfiguration::class)->getValue());
    }

    public function getParentTable()
    {
        return $this->translateVars($this->getConfig(TableParentConfiguration::class)->getValue());
    }

    public function writeTable(WriterInterface $writer)
    {
        if (!$this->isExternal()) {
            /* FIXME: [Zend] Table name is one time in singular form, one time in plural form.
             *       All table occurence need to be at the original form.
             *
             *       $this->getModelName() return singular form with correct camel case
             *       $this->getRawTableName() return original form with no camel case
             */
            $writer
                ->open($this->getTableFileName())
                ->write('<?php')
                ->write('')
                ->writeCallback(function(WriterInterface $writer, ?Table $_this = null) {
                    /** @var \MwbExporter\Configuration\Header $header */
                    $header = $this->getConfig(HeaderConfiguration::class);
                    if ($content = $header->getHeader()) {
                        $writer
                            ->writeComment($content)
                            ->write('')
                        ;
                    }
                    if ($_this->getConfig(CommentConfiguration::class)->getValue()) {
                        if ($content = $_this->getFormatter()->getComment(null)) {
                            $writer
                                ->writeComment($content)
                                ->write('')
                            ;
                        }
                    }
                })
                ->write('class '.$this->getTablePrefix().$this->getSchema()->getName().'_'. $this->getModelName().' extends '.$this->getParentTable())
                ->write('{')
                ->indent()
                    ->writeComment('@var string')
                    ->write('protected $_schema = \''. $this->getSchema()->getName() .'\';')
                    ->write('')
                    ->writeComment('@var string')
                    ->write('protected $_name = \''. $this->getRawTableName() .'\';')
                    ->write('')
                    ->writeCallback(function(WriterInterface $writer, ?Table $_this = null) {
                        if ($_this->getConfig(DRIConfiguration::class)->getValue()) {
                            $_this->writeDependencies($writer);
                        }
                    })
                    ->writeCallback(function(WriterInterface $writer, ?Table $_this = null) {
                        $_this->writeReferences($writer);
                    })
                ->outdent()
                ->write('}')
                ->write('')
                ->close()
            ;

            return self::WRITE_OK;
        }

        return self::WRITE_EXTERNAL;
    }

    public function writeDependencies(WriterInterface $writer)
    {
        //TODO: [Zend] Find a way to print dependance without change the core.
        $writer
            ->commentStart()
                ->write('@todo: this feature isn\'t implement yet')
                ->write('')
                ->write('@var array')
            ->commentEnd()
            ->write('protected $_dependentTables = [];')
            ->write('')
        ;

        return $this;
    }

    public function writeReferences(WriterInterface $writer)
    {
        $writer
            ->commentStart()
                ->write('@var array')
            ->commentEnd()
            ->writeCallback(function(WriterInterface $writer, ?Table $_this = null) {
                if (count($_this->getForeignKeys())) {
                    $writer->write('protected $_referenceMap = [');
                    $writer->indent();
                    foreach ($_this->getForeignKeys() as $foreignKey) {
                        $foreignKey->write($writer);
                    }
                    $writer->outdent();
                    $writer->write('];');
                } else {
                    $writer->write('protected $_referenceMap = [];');
                }
            })
        ;

        return $this;
    }
}
