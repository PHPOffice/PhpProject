<?php

/**
 * This file is part of PHPProject - A pure PHP library for reading and writing
 * project management files.
 *
 * PHPProject is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPProject/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPProject
 * @copyright   2009-2014 PHPProject contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

declare(strict_types=1);

namespace PhpOffice\PhpProject\Tests\Writer;

use PhpOffice\PhpProject\IOFactory;
use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\Tests\XmlDocument;

/**
 * Test class for MSPDI writer
 *
 * @runTestsInSeparateProcesses
 */
class MSPDITest extends \PHPUnit\Framework\TestCase
{
    public function testSave(): void
    {
        $fileOutput = tempnam(sys_get_temp_dir(), 'PHPPROJECT');

        $oPHPProject = new PhpProject();

        $oResource = $oPHPProject->createResource();
        $oResource->setTitle('ResourceTest');

        $oTask = $oPHPProject->createTask();
        $oTask->setName('Task1Test');
        $oTask->setStartDate('2014-08-07');
        $oTask->setEndDate('2014-08-13');
        $oTask->setDuration('PT8H0M0S');
        $oTask->setProgress(0.5);
        $oTask->addResource($oResource);

        $xmlWriter = IOFactory::createWriter($oPHPProject, 'MSPDI');
        $xmlWriter->save($fileOutput);

        $oXMLDocument = new XmlDocument();

        // Project
        $this->assertTrue($oXMLDocument->elementExists('/*[local-name()="Project"]', $fileOutput));

        // Resource
        $resource = '/*[local-name()="Project"]/*[local-name()="Resources"]/*[local-name()="Resource"]';
        $this->assertTrue($oXMLDocument->elementExists($resource, $fileOutput));
        $this->assertEquals('0', $oXMLDocument->getElement($resource.'/*[local-name()="UID"]', $fileOutput)->nodeValue);
        $this->assertEquals('ResourceTest', $oXMLDocument->getElement($resource.'/*[local-name()="Name"]', $fileOutput)->nodeValue);

        // Task
        $task = '/*[local-name()="Project"]/*[local-name()="Tasks"]/*[local-name()="Task"]';
        $this->assertTrue($oXMLDocument->elementExists($task, $fileOutput));
        $this->assertEquals('Task1Test', $oXMLDocument->getElement($task.'/*[local-name()="Name"]', $fileOutput)->nodeValue);
        $this->assertEquals('2014-08-07T00:00:00', $oXMLDocument->getElement($task.'/*[local-name()="Start"]', $fileOutput)->nodeValue);
        $this->assertEquals('2014-08-13T00:00:00', $oXMLDocument->getElement($task.'/*[local-name()="Finish"]', $fileOutput)->nodeValue);
        $this->assertEquals('PT8H0M0S', $oXMLDocument->getElement($task.'/*[local-name()="Work"]', $fileOutput)->nodeValue);
        $this->assertEquals('50', $oXMLDocument->getElement($task.'/*[local-name()="PercentComplete"]', $fileOutput)->nodeValue);

        // Assignment
        $assignment = '/*[local-name()="Project"]/*[local-name()="Assignments"]/*[local-name()="Assignment"]';
        $this->assertTrue($oXMLDocument->elementExists($assignment, $fileOutput));
        $this->assertEquals('0', $oXMLDocument->getElement($assignment.'/*[local-name()="TaskUID"]', $fileOutput)->nodeValue);
        $this->assertEquals('0', $oXMLDocument->getElement($assignment.'/*[local-name()="ResourceUID"]', $fileOutput)->nodeValue);
        $this->assertEquals('1', $oXMLDocument->getElement($assignment.'/*[local-name()="Units"]', $fileOutput)->nodeValue);
    }

    public function testSaveException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Could not open file");
        $fileOutput = tempnam(sys_get_temp_dir(), 'PHPPROJECT');
        file_put_contents($fileOutput, 'AA');
        chmod($fileOutput, 0044);

        $oPHPProject = new PhpProject();
        $oResource = $oPHPProject->createResource();
        $oResource->setTitle('ResourceTest');

        $xmlWriter = IOFactory::createWriter($oPHPProject, 'MSPDI');
        $xmlWriter->save($fileOutput);
    }
}
