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

use PhpOffice\PhpProject\Reader\MSPDI;

/**
 * Test class for MSPDI
 */
class MSPDITest extends \PHPUnit\Framework\TestCase
{
    /**
     * @return array<array{string, bool}>
     */
    public static function providerCanRead(): array
    {
        return [
            ['mspdiresource.xml', true],
            ['fileError', false],
        ];
    }

    /**
     * @dataProvider providerCanRead
     */
    public function testCanRead(string $filename, bool $expected): void
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.$filename;
        $object = new MSPDI();

        $this->assertEquals($expected, $object->canRead($file));
    }

    public function testLoad(): void
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'mspdiresource.xml';
        $object = new MSPDI();
        $return = $object->load($file);

        $this->assertInstanceOf('PhpOffice\\PhpProject\\PhpProject', $return);

        // Resources
        $resources = $return->getAllResources();
        $this->assertCount(5, $resources);
        $this->assertEquals('', $resources[0]->getTitle());
        $this->assertEquals('Wade Golden', $resources[1]->getTitle());
        $this->assertEquals('Jon Iles', $resources[2]->getTitle());
        $this->assertEquals('Brian Leach', $resources[3]->getTitle());
        $this->assertEquals('Concrete', $resources[4]->getTitle());
    }

    public function testLoadException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The file is not accessible.");
        $file404 = 'fileError';
        $object = new MSPDI();
        $object->load($file404);
    }
}
