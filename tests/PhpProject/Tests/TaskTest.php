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
use PhpOffice\PhpProject\Task;

/**
 * Test class for Task
 * @runTestsInSeparateProcesses
 */
class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Register
     */
    public function testConstruct()
    {
        $object = new Task();
        
        $this->assertCount(0, $object->getTasks());
        $this->assertCount(0, $object->getResources());
        $this->assertEquals(0, $object->getTaskCount());
        $this->assertEquals(0, $object->getResourceCount());
    }
    
    public function testGetSetDuration()
    {
        $object = new Task();
        
        $value = rand(1, 100);
    
        $this->assertEquals(0, $object->getDuration());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setDuration($value));
        $this->assertEquals($value, $object->getDuration());
    }
    
    public function testGetSetEndDate()
    {
        $object = new Task();
        
        $value = time();
    
        $this->assertEquals('', $object->getEndDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setEndDate());
        $this->assertEquals($value, $object->getEndDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setEndDate($value));
        $this->assertEquals($value, $object->getEndDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setEndDate((string)$value));
        $this->assertEquals($value, $object->getEndDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setEndDate('2014-12-05 00:05:00'));
        $this->assertEquals(strtotime('2014-12-05 00:05:00'), $object->getEndDate());
    }
    
    public function testGetSetIndex()
    {
        $object = new Task();
    
        $this->assertEquals(0, $object->getIndex());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setIndex('AAA'));
        $this->assertEquals(0, $object->getIndex());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setIndex('1'));
        $this->assertEquals(1, $object->getIndex());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setIndex(2));
        $this->assertEquals(2, $object->getIndex());
    }
    
    public function testGetSetName()
    {
        $object = new Task();
    
        $this->assertEquals('', $object->getName());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setName('AAA'));
        $this->assertEquals('AAA', $object->getName());
    }
    
    public function testGetSetProgress()
    {
        $object = new Task();
    
        $this->assertEquals(0, $object->getProgress());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setProgress('AAA'));
        $this->assertEquals(0, $object->getProgress());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setProgress(-1));
        $this->assertEquals(0, $object->getProgress());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setProgress(2));
        $this->assertEquals(1, $object->getProgress());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setProgress(0.5));
        $this->assertEquals(0.5, $object->getProgress());
    }
    
    public function testGetSetStartDate()
    {
        $object = new Task();
        
        $value = time();
    
        $this->assertEquals('', $object->getStartDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setStartDate());
        $this->assertEquals($value, $object->getStartDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setStartDate($value));
        $this->assertEquals($value, $object->getStartDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setStartDate((string)$value));
        $this->assertEquals($value, $object->getStartDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->setStartDate('2014-12-05 00:05:00'));
        $this->assertEquals(strtotime('2014-12-05 00:05:00'), $object->getStartDate());
    }
    
    public function testResource()
    {
        $object = new Task();
        $oResource = new Resource();
         
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->addResource($oResource));
        $this->assertCount(1, $object->getResources());
        $this->assertEquals(1, $object->getResourceCount());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->addResource($oResource));
        $this->assertCount(1, $object->getResources());
        $this->assertEquals(1, $object->getResourceCount());
    }
    
    public function testTask()
    {
        $object = new Task();
         
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->createTask());
        $this->assertCount(1, $object->getTasks());
        $this->assertEquals(1, $object->getTaskCount());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->createTask());
        $this->assertCount(2, $object->getTasks());
        $this->assertEquals(2, $object->getTaskCount());
    }
}
