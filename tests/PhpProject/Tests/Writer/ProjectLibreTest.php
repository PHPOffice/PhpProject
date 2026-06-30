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
use PhpOffice\PhpProject\Reader\ProjectLibre as ProjectLibreReader;
use PhpOffice\PhpProject\Writer\ProjectLibre as ProjectLibreWriter;

/**
 * Test class for ProjectLibre writer
 *
 * @runTestsInSeparateProcesses
 */
class ProjectLibreTest extends \PHPUnit\Framework\TestCase
{
    public function testSave(): void
    {
        $fileOutput = tempnam(sys_get_temp_dir(), 'PHPPROJECT');

        $oPHPProject = new PhpProject();

        $oResource = $oPHPProject->createResource();
        $oResource->setTitle('ResourceTest');

        $oTask = $oPHPProject->createTask();
        $oTask->setName('Task1Test');
        $oTask->addResource($oResource);

        $writer = IOFactory::createWriter($oPHPProject, 'ProjectLibre');
        $writer->save($fileOutput);

        // The file is a minimal `.pod`: Java preamble, separator, then MSPDI.
        $content = (string) file_get_contents($fileOutput);
        $this->assertStringStartsWith(ProjectLibreWriter::JAVA_PREAMBLE, $content);
        $this->assertStringContainsString(ProjectLibreReader::MSPDI_SEPARATOR, $content);

        // Round-trip: the ProjectLibre reader must read the data back.
        $oRead = (new ProjectLibreReader())->load($fileOutput);

        $resources = $oRead->getAllResources();
        $this->assertCount(1, $resources);
        $this->assertEquals('ResourceTest', $resources[0]->getTitle());

        $tasks = $oRead->getAllTasks();
        $this->assertCount(1, $tasks);
        $this->assertEquals('Task1Test', $tasks[0]->getName());
    }

    public function testSaveException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Could not open file');
        $fileOutput = tempnam(sys_get_temp_dir(), 'PHPPROJECT');
        file_put_contents($fileOutput, 'AA');
        chmod($fileOutput, 0044);

        $oPHPProject = new PhpProject();
        $oResource = $oPHPProject->createResource();
        $oResource->setTitle('ResourceTest');

        $writer = IOFactory::createWriter($oPHPProject, 'ProjectLibre');
        $writer->save($fileOutput);
    }
}
