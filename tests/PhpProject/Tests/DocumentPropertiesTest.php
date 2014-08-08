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

use PhpOffice\PhpProject\DocumentProperties;
use PhpOffice\PhpProject\PhpProject;

/**
 * Test class for Task
 */
class DocumentPropertiesTest extends \PHPUnit_Framework_TestCase
{
    public function testCustomProperties()
    {
        $object = new DocumentProperties();
        $this->assertInternalType('array', $object->getCustomProperties());
        $this->assertCount(0, $object->getCustomProperties());
        $this->assertFalse($object->isCustomPropertySet('AAAName'));
        $this->assertNull($object->getCustomPropertyType('AAAName'));
        $this->assertNull($object->getCustomPropertyValue('AAAName'));
        // Set Property Null > String
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCustomProperty('AAAName1', 'AAAValue'));
        $this->assertCount(1, $object->getCustomProperties());
        $this->assertTrue($object->isCustomPropertySet('AAAName1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_STRING, $object->getCustomPropertyType('AAAName1'));
        $this->assertEquals('AAAValue', $object->getCustomPropertyValue('AAAName1'));
        // Set Property Null > Float
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCustomProperty('AAAName1', (float)1.5));
        $this->assertCount(1, $object->getCustomProperties());
        $this->assertTrue($object->isCustomPropertySet('AAAName1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_FLOAT, $object->getCustomPropertyType('AAAName1'));
        $this->assertEquals(1.5, $object->getCustomPropertyValue('AAAName1'));
        // Set Property Null > Integer
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCustomProperty('AAAName1', (int)2));
        $this->assertCount(1, $object->getCustomProperties());
        $this->assertTrue($object->isCustomPropertySet('AAAName1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->getCustomPropertyType('AAAName1'));
        $this->assertEquals(2, $object->getCustomPropertyValue('AAAName1'));
        // Set Property Null > Boolean
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCustomProperty('AAAName1', true));
        $this->assertCount(1, $object->getCustomProperties());
        $this->assertTrue($object->isCustomPropertySet('AAAName1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_BOOLEAN, $object->getCustomPropertyType('AAAName1'));
        $this->assertTrue($object->getCustomPropertyValue('AAAName1'));
        // Set Property "Boolean"
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCustomProperty('AAAName1', 'AAAValue', DocumentProperties::PROPERTY_TYPE_BOOLEAN));
        $this->assertCount(1, $object->getCustomProperties());
        $this->assertTrue($object->isCustomPropertySet('AAAName1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_BOOLEAN, $object->getCustomPropertyType('AAAName1'));
        $this->assertEquals('AAAValue', $object->getCustomPropertyValue('AAAName1'));
        // Set Property "Date"
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCustomProperty('AAAName1', 'AAAValue', DocumentProperties::PROPERTY_TYPE_DATE));
        $this->assertCount(1, $object->getCustomProperties());
        $this->assertTrue($object->isCustomPropertySet('AAAName1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_DATE, $object->getCustomPropertyType('AAAName1'));
        $this->assertEquals('AAAValue', $object->getCustomPropertyValue('AAAName1'));
        // Set Property "Float"
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCustomProperty('AAAName1', 'AAAValue', DocumentProperties::PROPERTY_TYPE_FLOAT));
        $this->assertCount(1, $object->getCustomProperties());
        $this->assertTrue($object->isCustomPropertySet('AAAName1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_FLOAT, $object->getCustomPropertyType('AAAName1'));
        $this->assertEquals('AAAValue', $object->getCustomPropertyValue('AAAName1'));
        // Set Property "Integer"
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCustomProperty('AAAName1', 'AAAValue', DocumentProperties::PROPERTY_TYPE_INTEGER));
        $this->assertCount(1, $object->getCustomProperties());
        $this->assertTrue($object->isCustomPropertySet('AAAName1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->getCustomPropertyType('AAAName1'));
        $this->assertEquals('AAAValue', $object->getCustomPropertyValue('AAAName1'));
        // Set Property "String"
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCustomProperty('AAAName1', 'AAAValue', DocumentProperties::PROPERTY_TYPE_STRING));
        $this->assertCount(1, $object->getCustomProperties());
        $this->assertTrue($object->isCustomPropertySet('AAAName1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_STRING, $object->getCustomPropertyType('AAAName1'));
        $this->assertEquals('AAAValue', $object->getCustomPropertyValue('AAAName1'));
    }
    
    public function testCustomPropertiesConvertProperty()
    {
        $object = new DocumentProperties();
        $this->assertEmpty($object->convertProperty('AAA', 'empty'));
        $this->assertNull($object->convertProperty('AAA', 'null'));
        $this->assertSame(3, $object->convertProperty('3', 'i1'));
        $this->assertSame(3, $object->convertProperty('3', 'i2'));
        $this->assertSame(3, $object->convertProperty('3', 'i4'));
        $this->assertSame(3, $object->convertProperty('3', 'i8'));
        $this->assertSame(3, $object->convertProperty('3.5', 'ui1'));
        $this->assertSame(3, $object->convertProperty('3.5', 'ui2'));
        $this->assertSame(3, $object->convertProperty('3.5', 'ui4'));
        $this->assertSame(3, $object->convertProperty('3.5', 'ui8'));
        $this->assertSame(3.5, $object->convertProperty('3.5', 'r4'));
        $this->assertSame(3.5, $object->convertProperty('3.5', 'r8'));
        $this->assertSame(3.5, $object->convertProperty('3.5', 'decimal'));
        $this->assertSame(strtotime('2014-08-05 19:30:00'), $object->convertProperty('2014-08-05 19:30:00', 'date'));
        $this->assertSame(strtotime('2014-08-05 19:30:00'), $object->convertProperty('2014-08-05 19:30:00', 'filetime'));
        $this->assertSame(true, $object->convertProperty('true', 'bool'));
        $this->assertSame(false, $object->convertProperty('false', 'bool'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'lpstr'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'lpwstr'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'bstr'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'cy'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'error'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'vector'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'array'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'blob'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'oblob'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'stream'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'ostream'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'storage'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'ostorage'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'vstream'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'clsid'));
        $this->assertSame('3.5', $object->convertProperty('3.5', 'cf'));
    }
    
    public function testCustomPropertiesConvertPropertyType()
    {
        $object = new DocumentProperties();
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->convertPropertyType('i1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->convertPropertyType('i2'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->convertPropertyType('i4'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->convertPropertyType('i8'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->convertPropertyType('ui1'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->convertPropertyType('ui2'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->convertPropertyType('ui4'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_INTEGER, $object->convertPropertyType('ui8'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_FLOAT, $object->convertPropertyType('r4'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_FLOAT, $object->convertPropertyType('r8'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_FLOAT, $object->convertPropertyType('decimal'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_DATE, $object->convertPropertyType('date'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_DATE, $object->convertPropertyType('filetime'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_BOOLEAN, $object->convertPropertyType('bool'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_STRING, $object->convertPropertyType('empty'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_STRING, $object->convertPropertyType('null'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_STRING, $object->convertPropertyType('lpstr'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_STRING, $object->convertPropertyType('lpwstr'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_STRING, $object->convertPropertyType('bstr'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('cy'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('error'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('vector'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('array'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('blob'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('oblob'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('stream'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('ostream'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('storage'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('ostorage'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('vstream'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('clsid'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('cf'));
        $this->assertEquals(DocumentProperties::PROPERTY_TYPE_UNKNOWN, $object->convertPropertyType('TypeNotExists'));
    }
    
    public function testGetSetCategory()
    {
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCategory());
        $this->assertEquals('', $object->getCategory());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCategory('AAA'));
        $this->assertEquals('AAA', $object->getCategory());
    }
    
    public function testGetSetCompany()
    {
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCompany());
        $this->assertEquals('', $object->getCompany());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCompany('AAA'));
        $this->assertEquals('AAA', $object->getCompany());
    }
    
    public function testGetSetCreated()
    {
        $value = time();
    
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCreated());
        $this->assertEquals($value, $object->getCreated());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCreated((string) $value));
        $this->assertEquals($value, $object->getCreated());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCreated('2014-08-05 19:30:00'));
        $this->assertEquals(strtotime('2014-08-05 19:30:00'), $object->getCreated());
    }
    
    public function testGetSetCreator()
    {
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCreator());
        $this->assertEquals('', $object->getCreator());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setCreator('AAA'));
        $this->assertEquals('AAA', $object->getCreator());
    }
    
    public function testGetSetDescription()
    {
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setDescription());
        $this->assertEquals('', $object->getDescription());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setDescription('AAA'));
        $this->assertEquals('AAA', $object->getDescription());
    }
    
    public function testGetSetKeywords()
    {
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setKeywords());
        $this->assertEquals('', $object->getKeywords());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setKeywords('AAA'));
        $this->assertEquals('AAA', $object->getKeywords());
    }
    
    public function testGetSetLastModifiedBy()
    {
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setLastModifiedBy());
        $this->assertEquals('', $object->getLastModifiedBy());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setLastModifiedBy('AAA'));
        $this->assertEquals('AAA', $object->getLastModifiedBy());
    }

    public function testGetSetManager()
    {
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setManager());
        $this->assertEquals('', $object->getManager());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setManager('AAA'));
        $this->assertEquals('AAA', $object->getManager());
    }
    
    public function testGetSetModified()
    {
        $value = time();
    
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setModified());
        $this->assertEquals($value, $object->getModified());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setModified((string) $value));
        $this->assertEquals($value, $object->getModified());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setModified('2014-08-05 19:30:00'));
        $this->assertEquals(strtotime('2014-08-05 19:30:00'), $object->getModified());
    }
    
    public function testGetSetSubject()
    {
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setSubject());
        $this->assertEquals('', $object->getSubject());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setSubject('AAA'));
        $this->assertEquals('AAA', $object->getSubject());
    }
    
    public function testGetSetTitle()
    {
        $object = new DocumentProperties();
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setTitle());
        $this->assertEquals('', $object->getTitle());
        $this->assertInstanceOf('PhpOffice\\PhpProject\\DocumentProperties', $object->setTitle('AAA'));
        $this->assertEquals('AAA', $object->getTitle());
    }
}
