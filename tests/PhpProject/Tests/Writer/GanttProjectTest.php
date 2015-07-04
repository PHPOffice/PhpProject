<?php
/**
 * This XMLWriter is part of PHPPowerPoint - A pure PHP library for reading and writing
 * presentations documents.
 *
 * PHPPowerPoint is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * XMLWriter that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPPowerPoint/contributors.
 *
 * @copyright   2009-2014 PHPPowerPoint contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 * @link        https://github.com/PHPOffice/PHPPowerPoint
 */

namespace PhpOffice\PhpProject\Tests\Writer;

use PhpOffice\PhpProject\IOFactory;
use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\Writer\GanttProject;
use PhpOffice\PhpProject\Tests\XmlDocument;

/**
 * Test class for XMLWriter
 *
 * @coversDefaultClass PhpOffice\PhpPowerpoint\Shared\XMLWriter
 * @runTestsInSeparateProcesses
 */
class GanttProjectTest extends \PHPUnit_Framework_TestCase
{
    public function testSave()
    {
        $fileOutput = tempnam(sys_get_temp_dir(), 'PHPPROJECT');
        $oPHPProject = new PhpProject();
        
        $oResource = $oPHPProject->createResource();
        $oResource->setTitle('ResourceTest');
        
        $oTask1 = $oPHPProject->createTask();
        $oTask1->setName('Task1Test');
        $oTask1->addResource($oResource);
        
        $oTask1Child = $oTask1->createTask();
        $oTask1Child->setName('TaskChildTest');
        
        $oTask1ChildChild1 = $oTask1Child->createTask();
        $oTask1ChildChild1->setName('TaskChildChild1Test');
        $oTask1ChildChild1->setStartDate('2014-08-07');
        $oTask1ChildChild1->setDuration(2);
        $oTask1ChildChild2 = $oTask1Child->createTask();
        $oTask1ChildChild2->setName('TaskChildChild2Test');
        $oTask1ChildChild2->setStartDate('2014-08-06');
        $oTask1ChildChild2->setEndDate('2014-08-10');
        
        $oTask2 = $oPHPProject->createTask();
        $oTask2->setStartDate('2014-08-07');
        $oTask2->setEndDate('2014-08-13');
        $oTask2->setName('Task2Test');
        
        $xmlWriter = IOFactory::createWriter($oPHPProject, 'GanttProject');
        $xmlWriter->save($fileOutput);
        
        $oXMLDocument = new XmlDocument();
        
        $this->assertTrue($oXMLDocument->elementExists('/project', $fileOutput));
        $this->assertEquals('2014-08-06', $oXMLDocument->getElementAttribute('/project', 'view-date', $fileOutput));
        // Task 1
        $this->assertTrue($oXMLDocument->elementExists('/project/tasks/task[@id="0"]', $fileOutput));
        $this->assertEquals('Task1Test', $oXMLDocument->getElementAttribute('/project/tasks/task[@id="0"]', 'name', $fileOutput));
        $this->assertEquals('2014-08-06', $oXMLDocument->getElementAttribute('/project/tasks/task[@id="0"]', 'start', $fileOutput));
        $this->assertEquals('5', $oXMLDocument->getElementAttribute('/project/tasks/task[@id="0"]', 'duration', $fileOutput));
        // TaskChild
        $this->assertTrue($oXMLDocument->elementExists('/project/tasks/task/task[@id="1"]', $fileOutput));
        $this->assertEquals('TaskChildTest', $oXMLDocument->getElementAttribute('/project/tasks/task/task[@id="1"]', 'name', $fileOutput));
        $this->assertEquals('2014-08-06', $oXMLDocument->getElementAttribute('/project/tasks/task/task[@id="1"]', 'start', $fileOutput));
        $this->assertEquals('5', $oXMLDocument->getElementAttribute('/project/tasks/task/task[@id="1"]', 'duration', $fileOutput));
        // TaskChildChild
        $this->assertTrue($oXMLDocument->elementExists('/project/tasks/task/task/task[@id="2"]', $fileOutput));
        $this->assertEquals('TaskChildChild1Test', $oXMLDocument->getElementAttribute('/project/tasks/task/task/task[@id="2"]', 'name', $fileOutput));
        $this->assertEquals('2014-08-07', $oXMLDocument->getElementAttribute('/project/tasks/task/task/task[@id="2"]', 'start', $fileOutput));
        $this->assertEquals('2', $oXMLDocument->getElementAttribute('/project/tasks/task/task/task[@id="2"]', 'duration', $fileOutput));
        // TaskChildChild
        $this->assertTrue($oXMLDocument->elementExists('/project/tasks/task/task/task[@id="3"]', $fileOutput));
        $this->assertEquals('TaskChildChild2Test', $oXMLDocument->getElementAttribute('/project/tasks/task/task/task[@id="3"]', 'name', $fileOutput));
        $this->assertEquals('2014-08-06', $oXMLDocument->getElementAttribute('/project/tasks/task/task/task[@id="3"]', 'start', $fileOutput));
        $this->assertEquals('5', $oXMLDocument->getElementAttribute('/project/tasks/task/task/task[@id="3"]', 'duration', $fileOutput));
        // Task 2
        $this->assertTrue($oXMLDocument->elementExists('/project/tasks/task[@id="4"]', $fileOutput));
        $this->assertEquals('Task2Test', $oXMLDocument->getElementAttribute('/project/tasks/task[@id="4"]', 'name', $fileOutput));
        $this->assertEquals('2014-08-07', $oXMLDocument->getElementAttribute('/project/tasks/task[@id="4"]', 'start', $fileOutput));
        $this->assertEquals('7', $oXMLDocument->getElementAttribute('/project/tasks/task[@id="4"]', 'duration', $fileOutput));
        // Resource
        $this->assertTrue($oXMLDocument->elementExists('/project/resources/resource', $fileOutput));
        $this->assertEquals('ResourceTest', $oXMLDocument->getElementAttribute('/project/resources/resource', 'name', $fileOutput));
        // Allocation
        $this->assertTrue($oXMLDocument->elementExists('/project/allocations/allocation', $fileOutput));
        $this->assertTrue($oXMLDocument->elementExists('/project/allocations/allocation[@task-id="0"][@resource-id="0"]', $fileOutput));
    }
    
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Could not open file
     */
    public function testSaveException()
    {
        $fileOutput = tempnam(sys_get_temp_dir(), 'PHPPROJECT');
        file_put_contents($fileOutput, 'AA');
        chmod($fileOutput, 0044);
        
        $oPHPProject = new PhpProject();
         
        $oTask1 = $oPHPProject->createTask();
        $oTask1->setName('Task1Test');
         
        $xmlWriter = IOFactory::createWriter($oPHPProject, 'GanttProject');
        $xmlWriter->save($fileOutput);
    }
}
