<?php
/**
 * This file is part of PHPProject - A pure PHP library for reading and writing
 * presentations documents.
 *
 * PHPProject is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPProject/contributors.
 *
 * @copyright   2010-2014 PHPProject contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 * @link        https://github.com/PHPOffice/PHPProject
 */

namespace PhpOffice\PhpProject\Tests;

use PhpOffice\PhpProject\IOFactory;
use PhpOffice\PhpProject\PhpProject;

/**
 * Test class for Task
 */
class IOFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testLoad()
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'Sample_01_Simple.gan';
        $this->assertInstanceOf('PhpOffice\\PhpProject\\PhpProject', IOFactory::load($file));
    }    
    
    public function testLoadFileNotExists()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Could not automatically determine \PhpOffice\PhpProject\Reader\ReaderInterface for file.");
        IOFactory::load('fileNotExists');
    }
    
    public function testReader()
    {
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Reader\\GanttProject', IOFactory::createReader());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Reader\\GanttProject', IOFactory::createReader('GanttProject'));
    }    
    
    public function testReaderException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("\"ReaderNotExists\" is not a valid reader.");
        IOFactory::createReader('ReaderNotExists');
    }
    
    public function testWriter()
    {
        $object = new PhpProject();
    
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Writer\\GanttProject', IOFactory::createWriter($object));
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Writer\\GanttProject', IOFactory::createWriter($object, 'GanttProject'));
    }    
    
    public function testWriterException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("\"WriterNotExists\" is not a valid writer.");
        $object = new PhpProject();
        IOFactory::createWriter($object, 'WriterNotExists');
    }
}
