<?php
/**
 * This file is part of PHPProject - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPProject is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPProject/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPProject
 * @copyright   2010-2014 PHPProject contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpProject\Tests\Shared;

use PhpOffice\PhpProject\Shared\XMLReader;

/**
 * Test class for PhpOffice\PhpProject\Shared\XMLReader
 *
 * @runTestsInSeparateProcesses
 * @since 0.10.0
 */
class XMLReaderTest extends \PHPUnit\Framework\TestCase
{ 
    public function testGetDomFromZipException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Cannot find archive file.");  
        $filename = __DIR__ . "/../_files/documents/foo.zip";
        $object = new XMLReader();
        $object->getDomFromZip($filename, 'yadayadaya');
    }

    /**
     * Test get DOMDocument from ZipArchive returns false
     */
    public function testGetDomFromZipReturnsFalse(): void
    {
        $filename = __DIR__ . "/../../resources/reader.docx.zip";
        $object = new XMLReader();
        $this->assertFalse($object->getDomFromZip($filename, 'yadayadaya'));
    }

    /**
     * Test get element
     */
    public function testGetElement(): void
    {
        $filename = __DIR__ . "/../../resources/reader.docx.zip";
        $object = new XMLReader();
        $object->getDomFromZip($filename, 'word/document.xml');
        $this->assertInstanceOf('\\DOMElement', $object->getElement('w:body'));
    }

    /**
     * Test get elements returns empty
     */
    public function testGetElementsReturnsEmpty(): void
    {
        $object = new XMLReader();
        $this->assertEquals(array(), $object->getElements('w:document'));
    }

    /**
     * Test get element returns null
     */
    public function testGetElementReturnsNull(): void
    {
        $filename = __DIR__ . "/../../resources/reader.docx.zip";

        $object = new XMLReader();
        $object->getDomFromZip($filename, '[Content_Types].xml');
        $element = $object->getElements('*')->item(0);

        $this->assertNull($object->getElement('yadayadaya', $element));
    }

    /**
     * Test get attribute
     */
    public function testGetAttribute(): void
    {
        $filename = __DIR__ . "/../../resources/reader.docx.zip";
        $object = new XMLReader();
        $object->getDomFromZip($filename, 'word/document.xml');
        $node = $object->getElement('w:body/w:p');
        $this->assertEquals('00DE4826', $object->getAttribute('w:rsidR', $node));
    }

    /**
     * Test get attribute
     */
    public function testGetAttributeWithPath(): void
    {
        $filename = __DIR__ . "/../../resources/reader.docx.zip";
        $object = new XMLReader();
        $object->getDomFromZip($filename, 'word/document.xml');
        $node = $object->getElement('w:body');
        $this->assertEquals('00DE4826', $object->getAttribute('w:rsidR', $node, 'w:p'));
    }

    /**
     * Test get attribute
     */
    public function testGetValue(): void
    {
        $filename = __DIR__ . "/../../resources/reader.docx.zip";
        $object = new XMLReader();
        $object->getDomFromZip($filename, 'word/document.xml');
        $this->assertEquals('Section 1', $object->getValue('w:body/w:p/w:r/w:t'));
    }

    /**
     * Test get attribute
     */
    public function testGetValueNull(): void
    {
        $filename = __DIR__ . "/../../resources/reader.docx.zip";
        $object = new XMLReader();
        $object->getDomFromZip($filename, 'word/document.xml');
        $this->assertNull($object->getValue('w:body/w:p/w:r/w:t2'));
    }

    /**
     * Test count Elements
     */
    public function testCountElements(): void
    {
        $filename = __DIR__ . "/../../resources/reader.docx.zip";
        $object = new XMLReader();
        $object->getDomFromZip($filename, 'word/document.xml');
        $this->assertEquals(1, $object->countElements('w:body/w:p[@w:rsidR="00DE4826"]/w:r/w:t'));
    }

    /**
     * Test count Elements
     */
    public function testElementExists(): void
    {
        $filename = __DIR__ . "/../../resources/reader.docx.zip";
        $object = new XMLReader();
        $object->getDomFromZip($filename, 'word/document.xml');
        $this->assertTrue($object->elementExists('w:body/w:p/w:r/w:t'));
        $this->assertFalse($object->elementExists('w:body/w:p/w:r/w:tNotExists'));
    }
}
