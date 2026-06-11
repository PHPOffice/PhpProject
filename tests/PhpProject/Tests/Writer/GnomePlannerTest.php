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

        $xmlWriter = IOFactory::createWriter($oPHPProject, 'GnomePlanner');
        $xmlWriter->save($fileOutput);

        $oXMLDocument = new XmlDocument();

        // Project
        $this->assertTrue($oXMLDocument->elementExists('/project', $fileOutput));
        $this->assertEquals('2', $oXMLDocument->getElementAttribute('/project', 'mrproject-version', $fileOutput));

        // Resource
        $this->assertTrue($oXMLDocument->elementExists('/project/resources/resource', $fileOutput));
        $this->assertEquals('0', $oXMLDocument->getElementAttribute('/project/resources/resource', 'id', $fileOutput));
        $this->assertEquals('ResourceTest', $oXMLDocument->getElementAttribute('/project/resources/resource', 'name', $fileOutput));
    }
}
