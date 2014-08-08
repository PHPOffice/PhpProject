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
 * contributors, visit https://github.com/PHPOffice/PHPProject/contributors.
 *
 * @copyright   2010-2014 PHPProject contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 * @link        https://github.com/PHPOffice/PHPProject
 */

namespace PhpOffice\PhpProject\Tests;

use PhpOffice\PhpProject\DocumentInformations;
use PhpOffice\PhpProject\PhpProject;

/**
 * Test class for Task
 */
class DocumentInformationsTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $object = new DocumentInformations();
        $this->assertEmpty($object->getStartDate());
        $this->assertEmpty($object->getEndDate());
    }
    
    public function testEndDate()
    {
        $value = time();
        
        $object = new DocumentInformations();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentInformations', $object->setEndDate());
        $this->assertEquals($value, $object->getEndDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentInformations', $object->setEndDate((string) $value));
        $this->assertEquals($value, $object->getEndDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentInformations', $object->setEndDate('2014-08-05 19:30:00'));
        $this->assertEquals(strtotime('2014-08-05 19:30:00'), $object->getEndDate());
    }
    
    public function testStartDate()
    {
        $value = time();
        
        $object = new DocumentInformations();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentInformations', $object->setStartDate());
        $this->assertEquals($value, $object->getStartDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentInformations', $object->setStartDate((string) $value));
        $this->assertEquals($value, $object->getStartDate());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentInformations', $object->setStartDate('2014-08-05 19:30:00'));
        $this->assertEquals(strtotime('2014-08-05 19:30:00'), $object->getStartDate());
    }
}
