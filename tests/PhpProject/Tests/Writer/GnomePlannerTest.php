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
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
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
 * Test class for GnomePlanner writer
 *
 * @runTestsInSeparateProcesses
 */
class GnomePlannerTest extends \PHPUnit\Framework\TestCase
{
    public function testSave(): void
    {
        $fileOutput = tempnam(sys_get_temp_dir(), 'PHPPROJECT');

        $oPHPProject = new PhpProject();

        $oResource = $oPHPProject->createResource();
        $oResource->setTitle('ResourceTest');

        $oTask1 = $oPHPProject->createTask();
        $oTask1->setName('Task1Test');
        $oTask1->setStartDate('2014-08-07');
        $oTask1->setDuration(5);

        $oTask1Child = $oTask1->createTask();
        $oTask1Child->setName('TaskChildTest');
        $oTask1Child->setEndDate('2014-08-13');
        $oTask1Child->setProgress(0.5);

        $xmlWriter = IOFactory::createWriter($oPHPProject, 'GnomePlanner');
        $xmlWriter->save($fileOutput);

        $oXMLDocument = new XmlDocument();

        // Project
        $this->assertTrue($oXMLDocument->elementExists('/project', $fileOutput));
        $this->assertEquals('2', $oXMLDocument->getElementAttribute('/project', 'mrproject-version', $fileOutput));

        // Task 1
        $this->assertTrue($oXMLDocument->elementExists('/project/tasks/task[@id="0"]', $fileOutput));
        $this->assertEquals('Task1Test', $oXMLDocument->getElementAttribute('/project/tasks/task[@id="0"]', 'name', $fileOutput));
        $this->assertEquals('20140807T000000Z', $oXMLDocument->getElementAttribute('/project/tasks/task[@id="0"]', 'start', $fileOutput));
        $this->assertEquals('5', $oXMLDocument->getElementAttribute('/project/tasks/task[@id="0"]', 'work', $fileOutput));

        // Task 1 child (subtask)
        $this->assertTrue($oXMLDocument->elementExists('/project/tasks/task/task[@id="1"]', $fileOutput));
        $this->assertEquals('TaskChildTest', $oXMLDocument->getElementAttribute('/project/tasks/task/task[@id="1"]', 'name', $fileOutput));
        $this->assertEquals('20140813T000000Z', $oXMLDocument->getElementAttribute('/project/tasks/task/task[@id="1"]', 'end', $fileOutput));
        $this->assertEquals('50', $oXMLDocument->getElementAttribute('/project/tasks/task/task[@id="1"]', 'percent-complete', $fileOutput));

        // Resource
        $this->assertTrue($oXMLDocument->elementExists('/project/resources/resource', $fileOutput));
        $this->assertEquals('0', $oXMLDocument->getElementAttribute('/project/resources/resource', 'id', $fileOutput));
        $this->assertEquals('ResourceTest', $oXMLDocument->getElementAttribute('/project/resources/resource', 'name', $fileOutput));
    }
}
