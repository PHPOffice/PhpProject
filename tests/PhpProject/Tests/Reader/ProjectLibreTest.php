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

namespace PhpOffice\PhpProject\Tests\Reader;

use PhpOffice\PhpProject\Reader\ProjectLibre;

/**
 * Test class for ProjectLibre
 */
class ProjectLibreTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return array<array{string, bool}>
     */
    public static function providerCanRead(): array
    {
        return [
            ['projectlibre.pod', true],
            ['mspdiresource.xml', false],
            ['fileError', false],
        ];
    }

    /**
     * @dataProvider providerCanRead
     */
    public function testCanRead(string $filename, bool $expected): void
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.$filename;
        $object = new ProjectLibre();

        $this->assertEquals($expected, $object->canRead($file));
    }

    public function testLoad(): void
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'projectlibre.pod';
        $object = new ProjectLibre();
        $return = $object->load($file);

        $this->assertInstanceOf('PhpOffice\\PhpProject\\PhpProject', $return);

        // Resources (read from the embedded MSPDI part)
        $resources = $return->getAllResources();
        $this->assertCount(5, $resources);
        $this->assertEquals('Unassigned', $resources[0]->getTitle());
        $this->assertEquals('Ruth Eira Jones', $resources[1]->getTitle());

        // Tasks
        $tasks = $return->getAllTasks();
        $this->assertCount(35, $tasks);
        $this->assertEquals('Initiate transmedia project', $tasks[0]->getName());
    }

    public function testLoadExceptionNotAccessible(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The file is not accessible.');
        $object = new ProjectLibre();
        $object->load('fileError');
    }

    public function testLoadExceptionNotProjectLibre(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('The file is not a valid ProjectLibre file.');
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'mspdiresource.xml';
        $object = new ProjectLibre();
        $object->load($file);
    }
}
