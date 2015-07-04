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

use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\DocumentInformations;
use PhpOffice\PhpProject\DocumentProperties;

/**
 * Test class for Task
 */
class PhpProjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Register
     */
    public function testConstruct()
    {
        $object = new PhpProject();

        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->getProperties());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentInformations', $object->getInformations());
    }
    
    public function testGetSetInformations()
    {
        $object = new PhpProject();
        $oInformations = new DocumentInformations();

        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentInformations', $object->getInformations());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\PhpProject', $object->setInformations($oInformations));
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentInformations', $object->getInformations());
    }
    
    public function testGetSetProperties()
    {
        $object = new PhpProject();
        $oProperties = new DocumentProperties();

        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->getProperties());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\PhpProject', $object->setProperties($oProperties));
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->getProperties());
    }
    
    public function testResource()
    {
        $object = new PhpProject();

        // Start
        $this->assertEquals(0, $object->getResourceCount());
        $this->assertCount(0, $object->getAllResources());
        $this->assertInternalType('array', $object->getAllResources());
        $this->assertNull($object->getActiveResource());
        // Add a resource
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Resource', $object->createResource());
        $this->assertEquals(1, $object->getResourceCount());
        $this->assertCount(1, $object->getAllResources());
        $this->assertInternalType('array', $object->getAllResources());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Resource', $object->getActiveResource());
    }
    
    public function testResourceFromIndex()
    {
        $object = new PhpProject();
        $oResource1 = $object->createResource();
        $oResource1->setIndex(2);
        $oResource2 = $object->createResource();
        $oResource2->setIndex(4);
         
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Resource', $object->getResourceFromIndex(2));
        $this->assertNull($object->getResourceFromIndex(1));
    }
    
    public function testTask()
    {
        $object = new PhpProject();
    
        // Start
        $this->assertEquals(0, $object->getTaskCount());
        $this->assertCount(0, $object->getAllTasks());
        $this->assertInternalType('array', $object->getAllTasks());
        $this->assertNull($object->getActiveTask());
        // Add a task
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->createTask());
        $this->assertEquals(1, $object->getTaskCount());
        $this->assertCount(1, $object->getAllTasks());
        $this->assertInternalType('array', $object->getAllTasks());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->getActiveTask());
        // Add a task
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->createTask());
        $this->assertEquals(2, $object->getTaskCount());
        $this->assertCount(2, $object->getAllTasks());
        $this->assertInternalType('array', $object->getAllTasks());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->getActiveTask());
        // Remove Task
        $object->removeTaskByIndex(0);
        $this->assertEquals(1, $object->getTaskCount());
        $this->assertCount(1, $object->getAllTasks());
        $this->assertInternalType('array', $object->getAllTasks());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->getActiveTask());
    }
    
    public function testTaskFromIndex()
    {
        $object = new PhpProject();
        $oTask1 = $object->createTask();
        $oTask1->setIndex(2);
        $oTask11 = $oTask1->createTask();
        $oTask11->setIndex(22);
        $oTask2 = $object->createTask();
        $oTask2->setIndex(4);
        
        $this->assertInstanceOf('PhpOffice\\PhpProject\\Task', $object->getTaskFromIndex(2));
        $this->assertNull($object->getTaskFromIndex(1));
    }
    
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Task index is out of bounds.
     */
    public function testTaskRemoveException()
    {
        $object = new PhpProject();
        $object->removeTaskByIndex();
    }
}
