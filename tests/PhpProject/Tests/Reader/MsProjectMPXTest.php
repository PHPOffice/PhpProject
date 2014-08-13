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

use PhpOffice\PhpProject\Reader\MsProjectMPX;

/**
 * Test class for XMLWriter
 *
 * @coversDefaultClass PhpOffice\PhpPowerpoint\Shared\XMLWriter
 */
class MsProjectMPXTest extends \PHPUnit_Framework_TestCase
{
    public function testCanRead()
    {
        $fileMPX = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'Sample_02.mpx';
        $fileGAN = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'Sample_02.gan';
        $file404 = 'fileError';
        
        $object = new MsProjectMPX();
        
        $this->assertTrue($object->canRead($fileMPX));
        $this->assertFalse($object->canRead($fileGAN));
        $this->assertFalse($object->canRead($file404));
    }
    
    public function testLoad()
    {
        $file = PHPPROJECT_TESTS_BASE_DIR.DIRECTORY_SEPARATOR.'PhpProject'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'Sample_02.mpx';
        $object = new MsProjectMPX();
        $return = $object->load($file);
         
        $this->assertInstanceOf('PhpOffice\\PhpProject\\PhpProject', $return);
        $this->assertEquals(2, $return->getResourceCount());
        $this->assertEquals(2, $return->getTaskCount());
    }
    
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage The file is not accessible. 
     */
    public function testLoadException()
    {
        $file404 = 'fileError';
        $object = new MsProjectMPX();
        $object->load($file404);
    }
}
