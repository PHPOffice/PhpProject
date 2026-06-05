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

namespace PhpOffice\PhpProject\Tests\Reader;

use PhpOffice\PhpProject\Reader\Planner;

/**
 * Test class for XMLWriter
 *
 * @coversDefaultClass PhpOffice\PhpPowerpoint\Shared\XMLWriter
 */
class PlannerTest extends \PHPUnit\Framework\TestCase
{
    public function testCanRead(): void
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'kitchen.planner';
        $file404 = 'fileError';
        
        $object = new Planner();
        
        $this->assertTrue($object->canRead($file));
        $this->assertFalse($object->canRead($file404));
    }
    
    public function testLoad(): void
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'kitchen.planner';
        $object = new Planner();
        $return = $object->load($file);
         
        $this->assertInstanceOf('PhpOffice\\PhpProject\\PhpProject', $return);
        $this->assertEquals(5, $return->getResourceCount());

        $resources = $return->getAllResources();
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
        $object = new Planner();
        $object->load($file404);
    }
}
