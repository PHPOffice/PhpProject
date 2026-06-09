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

namespace PhpOffice\PhpProject\Tests\Reader;

use PhpOffice\PhpProject\Reader\GnomePlanner;

/**
 * Test class for GnomePlanner
 */
class GnomePlannerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return array<array{string, bool}>
     */
    public static function providerCanRead(): array
    {
        return [
            ['kitchen.planner', true],
            ['fileError', false],
        ];
    }

    /**
     * @dataProvider providerCanRead
     */
    public function testCanRead(string $filename, bool $expected): void
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.$filename;
        $object = new GnomePlanner();

        $this->assertEquals($expected, $object->canRead($file));
    }

    public function testLoad(): void
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'kitchen.planner';
        $object = new GnomePlanner();
        $return = $object->load($file);

        $this->assertInstanceOf('PhpOffice\\PhpProject\\PhpProject', $return);

        $resources = $return->getAllResources();
        $this->assertCount(5, $resources);
        $this->assertEquals('Town Engineer', $resources[0]->getTitle());
        $this->assertEquals('Architect', $resources[1]->getTitle());
        $this->assertEquals('Menard Construction', $resources[2]->getTitle());
        $this->assertEquals('Sue Maute', $resources[3]->getTitle());
        $this->assertEquals('Kurt Maute', $resources[4]->getTitle());
    }

    public function testLoadException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The file is not accessible.");
        $file404 = 'fileError';
        $object = new GnomePlanner();
        $object->load($file404);
    }

    public function testLoadTasks(): void
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'kitchen.planner';
        $object = new GnomePlanner();
        $return = $object->load($file);

        $this->assertInstanceOf('PhpOffice\\PhpProject\\PhpProject', $return);

        $tasks = $return->getAllTasks();
        $this->assertCount(4, $tasks);
        $this->assertEquals('Initiation', $tasks[0]->getName());
        $this->assertEquals('Planning', $tasks[1]->getName());
        $this->assertEquals('Execution', $tasks[2]->getName());
        $this->assertEquals('Closure', $tasks[3]->getName());

        $this->assertEquals(1072569600, $tasks[0]->getStartDate());
        $this->assertEquals(1073811600, $tasks[0]->getEndDate());
        $this->assertEquals('288000', $tasks[0]->getDuration());

        $initiation = $tasks[0]->getTasks();
        $this->assertCount(3, $initiation);
        $this->assertEquals('Define Objectives', $initiation[0]->getName());
        $this->assertEquals('Return on Investment Analysis', $initiation[1]->getName());
        $this->assertEquals('Go/No-Go Decision', $initiation[2]->getName());

        $planning = $tasks[1]->getTasks();
        $this->assertCount(4, $planning);
        $this->assertEquals('Scope', $planning[0]->getName());

        $scope = $planning[0]->getTasks();
        $this->assertCount(4, $scope);
        $this->assertEquals('Design Layout', $scope[0]->getName());
    }

}

