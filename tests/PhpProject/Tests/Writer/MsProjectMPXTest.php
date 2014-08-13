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
use PhpOffice\PhpProject\Writer\MsProjectMPX;

/**
 * Test class for MsProjectMPX
 *
 * @coversDefaultClass PhpOffice\PhpProject\Writer\MsProjectMPX
 */
class MsProjectMPXTest extends \PHPUnit_Framework_TestCase
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
        
        $xmlWriter = IOFactory::createWriter($oPHPProject, 'MsProjectMPX');
        $xmlWriter->save($fileOutput);
        
        $content = file_get_contents($fileOutput);
        $content = explode(PHP_EOL, $content);
        
        foreach ($content as $line) {
            $line = explode(';', $line);
            
            switch ($line[0]) {
                case 'MPX':
                    $this->assertEquals('Microsoft Project for Windows', $line[1]);
                    break;
            }
        }
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
         
        $xmlWriter = IOFactory::createWriter($oPHPProject, 'MsProjectMPX');
        $xmlWriter->save($fileOutput);
    }
}
