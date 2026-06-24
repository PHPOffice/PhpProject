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

/**
 * Test class for HTML writer
 *
 * @runTestsInSeparateProcesses
 */
class HTMLTest extends \PHPUnit\Framework\TestCase
{
    public function testSave(): void
    {
        $fileOutput = tempnam(sys_get_temp_dir(), 'PHPPROJECT');

        $oPHPProject = new PhpProject();

        $oTask = $oPHPProject->createTask();
        $oTask->setName('Task1Test');
        $oTask->setStartDate('2014-08-07');
        $oTask->setEndDate('2014-08-13');
        $oTask->setProgress(0.5);

        $oSubTask = $oTask->createTask();
        $oSubTask->setName('SubTaskTest');

        $writer = IOFactory::createWriter($oPHPProject, 'HTML');
        $writer->save($fileOutput);

        $content = (string) file_get_contents($fileOutput);

        // frappe-gantt includes and container
        $this->assertStringContainsString('frappe-gantt.css', $content);
        $this->assertStringContainsString('frappe-gantt.umd.js', $content);
        $this->assertStringContainsString('<div id="gantt"></div>', $content);
        $this->assertStringContainsString('new Gantt("#gantt", tasks)', $content);

        // Task
        $this->assertStringContainsString('"name":"Task1Test"', $content);
        $this->assertStringContainsString('"start":"2014-08-07"', $content);
        $this->assertStringContainsString('"end":"2014-08-13"', $content);
        $this->assertStringContainsString('"progress":50', $content);

        // Sub-task (heritage)
        $this->assertStringContainsString('"name":"SubTaskTest"', $content);
    }

    public function testSaveException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Could not open file");
        $fileOutput = tempnam(sys_get_temp_dir(), 'PHPPROJECT');
        file_put_contents($fileOutput, 'AA');
        chmod($fileOutput, 0044);

        $oPHPProject = new PhpProject();
        $oTask = $oPHPProject->createTask();
        $oTask->setName('Task1Test');

        $writer = IOFactory::createWriter($oPHPProject, 'HTML');
        $writer->save($fileOutput);
    }
}
