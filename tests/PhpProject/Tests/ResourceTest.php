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

use PhpOffice\PhpProject\Resource;

/**
 * Test class for Resource
 * @runTestsInSeparateProcesses
 */
class ResourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Register
     */
    public function testConstruct()
    {
        $object = new Resource();
        
        $this->assertEquals('', $object->getTitle());
        $this->assertEquals(0, $object->getIndex());
    }
    
    public function testGetSetIndex()
    {
        $object = new Resource();
    
        $this->assertEquals(0, $object->getIndex());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Resource', $object->setIndex('AAA'));
        $this->assertEquals(0, $object->getIndex());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Resource', $object->setIndex('1'));
        $this->assertEquals(1, $object->getIndex());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Resource', $object->setIndex(2));
        $this->assertEquals(2, $object->getIndex());
    }
    
    public function testGetSetTitle()
    {
        $object = new Resource();
    
        $this->assertEquals('', $object->getTitle());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Resource', $object->setTitle('AAA'));
        $this->assertEquals('AAA', $object->getTitle());
    }
}
