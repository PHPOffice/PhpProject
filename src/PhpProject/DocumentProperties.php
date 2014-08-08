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
 * contributors, visit https: // github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https: // github.com/PHPOffice/PHPProject
 * @copyright   2009-2014 PHPProject contributors
 * @license     http: // www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpProject;

/**
 * PHPProject_DocumentProperties
 *
 * @category    PHPProject
 * @package        PHPProject
 * @copyright    Copyright (c) 2012 - 2012 PHPProject (https: // github.com/PHPOffice/PHPProject)
 */
class DocumentProperties
{
    /** constants */
    const PROPERTY_TYPE_BOOLEAN        = 'b';
    const PROPERTY_TYPE_INTEGER        = 'i';
    const PROPERTY_TYPE_FLOAT        = 'f';
    const PROPERTY_TYPE_DATE        = 'd';
    const PROPERTY_TYPE_STRING        = 's';
    const PROPERTY_TYPE_UNKNOWN        = 'u';


    /**
     * Creator
     *
     * @var    string
     */
    private $creator    = '';

    /**
     * LastModifiedBy
     *
     * @var    string
     */
    private $lastModifiedBy;

    /**
     * Created
     *
     * @var int
     */
    private $created;

    /**
     * Modified
     *
     * @var    int
     */
    private $modified;

    /**
     * Title
     *
     * @var    string
     */
    private $title    = '';

    /**
     * Description
     *
     * @var    string
     */
    private $description    = '';

    /**
     * Subject
     *
     * @var    string
     */
    private $subject        = '';

    /**
     * Keywords
     *
     * @var    string
     */
    private $keywords        = '';

    /**
     * Category
     *
     * @var    string
     */
    private $category        = '';

    /**
     * Manager
     *
     * @var    string
     */
    private $manager        = '';

    /**
     * Company
     *
     * @var    string
     */
    private $company        = '';

    /**
     * Custom Properties
     *
     * @var    string[]
     */
    private $customProperties    = array();


    /**
     * Create a new PHPProject_DocumentProperties
     */
    public function __construct()
    {
        // Initialise values
        $this->lastModifiedBy    = $this->creator;
    }

    /**
     * Get Creator
     *
     * @return    string
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set Creator
     *
     * @param    string    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setCreator($pValue = '')
    {
        $this->creator = $pValue;
        return $this;
    }

    /**
     * Get Last Modified By
     *
     * @return    string
     */
    public function getLastModifiedBy()
    {
        return $this->lastModifiedBy;
    }

    /**
     * Set Last Modified By
     *
     * @param    string    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setLastModifiedBy($pValue = '')
    {
        $this->lastModifiedBy = $pValue;
        return $this;
    }

    /**
     * Get Created
     *
     * @return    int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set Created
     *
     * @param    int    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setCreated($pValue = null)
    {
        if ($pValue === null) {
            $pValue = time();
        } elseif (is_string($pValue)) {
            if (is_numeric($pValue)) {
                $pValue = intval($pValue);
            } else {
                $pValue = strtotime($pValue);
            }
        }

        $this->created = $pValue;
        return $this;
    }

    /**
     * Get Modified
     *
     * @return    int
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set Modified
     *
     * @param    int    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setModified($pValue = null)
    {
        if ($pValue === null) {
            $pValue = time();
        } elseif (is_string($pValue)) {
            if (is_numeric($pValue)) {
                $pValue = intval($pValue);
            } else {
                $pValue = strtotime($pValue);
            }
        }

        $this->modified = $pValue;
        return $this;
    }

    /**
     * Get Title
     *
     * @return    string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Title
     *
     * @param    string    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setTitle($pValue = '')
    {
        $this->title = $pValue;
        return $this;
    }

    /**
     * Get Description
     *
     * @return    string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Description
     *
     * @param    string    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setDescription($pValue = '')
    {
        $this->description = $pValue;
        return $this;
    }

    /**
     * Get Subject
     *
     * @return    string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set Subject
     *
     * @param    string    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setSubject($pValue = '')
    {
        $this->subject = $pValue;
        return $this;
    }

    /**
     * Get Keywords
     *
     * @return    string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set Keywords
     *
     * @param    string    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setKeywords($pValue = '')
    {
        $this->keywords = $pValue;
        return $this;
    }

    /**
     * Get Category
     *
     * @return    string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set Category
     *
     * @param    string    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setCategory($pValue = '')
    {
        $this->category = $pValue;
        return $this;
    }

    /**
     * Get Company
     *
     * @return    string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set Company
     *
     * @param    string    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setCompany($pValue = '')
    {
        $this->company = $pValue;
        return $this;
    }

    /**
     * Get Manager
     *
     * @return    string
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set Manager
     *
     * @param    string    $pValue
     * @return    PHPProject_DocumentProperties
     */
    public function setManager($pValue = '')
    {
        $this->manager = $pValue;
        return $this;
    }

    /**
     * Get a List of Custom Property Names
     *
     * @return string[]
     */
    public function getCustomProperties()
    {
        return array_keys($this->customProperties);
    }

    /**
     * Check if a Custom Property is defined
     *
     * @param    string    $propertyName
     * @return    boolean
     */
    public function isCustomPropertySet($propertyName)
    {
        return isset($this->customProperties[$propertyName]);
    }

    /**
     * Get a Custom Property Value
     *
     * @param    string    $propertyName
     * @return    string
     */
    public function getCustomPropertyValue($propertyName)
    {
        if (isset($this->customProperties[$propertyName])) {
            return $this->customProperties[$propertyName]['value'];
        }

    }

    /**
     * Get a Custom Property Type
     *
     * @param    string    $propertyName
     * @return    string
     */
    public function getCustomPropertyType($propertyName)
    {
        if (isset($this->customProperties[$propertyName])) {
            return $this->customProperties[$propertyName]['type'];
        }

    }

    /**
     * Set a Custom Property
     *
     * @param    string    $propertyName
     * @param    mixed    $propertyValue
     * @param    string    $propertyType
     *                        'i': Integer
     *                        'f': Floating Point
     *                        's': String
     *                        'd': Date/Time
     *                        'b': Boolean
     * @return    PHPProject_DocumentProperties
     */
    public function setCustomProperty($propertyName, $propertyValue = '', $propertyType = null)
    {
        if (($propertyType === null) || (!in_array($propertyType, array(self::PROPERTY_TYPE_INTEGER, self::PROPERTY_TYPE_FLOAT, self::PROPERTY_TYPE_STRING, self::PROPERTY_TYPE_DATE, self::PROPERTY_TYPE_BOOLEAN)))) {
            if (is_float($propertyValue)) {
                $propertyType = self::PROPERTY_TYPE_FLOAT;
            } elseif (is_int($propertyValue)) {
                $propertyType = self::PROPERTY_TYPE_INTEGER;
            } elseif (is_bool($propertyValue)) {
                $propertyType = self::PROPERTY_TYPE_BOOLEAN;
            } else {
                $propertyType = self::PROPERTY_TYPE_STRING;
            }
        }

        $this->customProperties[$propertyName] = array('value' => $propertyValue, 'type' => $propertyType);
        return $this;
    }

    public static function convertProperty($propertyValue, $propertyType)
    {
        switch ($propertyType) {
            case 'empty': // Empty
                $propertyValue = '';
                break;
            case 'null': // Null
                $propertyValue = null;
                break;
            case 'i1': // 1-Byte Signed Integer
            case 'i2': // 2-Byte Signed Integer
            case 'i4': // 4-Byte Signed Integer
            case 'i8': // 8-Byte Signed Integer
            case 'int': // Integer
                $propertyValue = (int) $propertyValue;
                break;
            case 'ui1': // 1-Byte Unsigned Integer
            case 'ui2': // 2-Byte Unsigned Integer
            case 'ui4': // 4-Byte Unsigned Integer
            case 'ui8': // 8-Byte Unsigned Integer
            case 'uint': // Unsigned Integer
                $propertyValue = abs((int) $propertyValue);
                break;
            case 'r4': // 4-Byte Real Number
            case 'r8': // 8-Byte Real Number
            case 'decimal': // Decimal
                $propertyValue = (float) $propertyValue;
                break;
            case 'lpstr': // LPSTR
            case 'lpwstr': // LPWSTR
            case 'bstr': // Basic String
                break;
            case 'date': // Date and Time
            case 'filetime': // File Time
                $propertyValue = strtotime($propertyValue);
                break;
            case 'bool': // Boolean
                $propertyValue = ($propertyValue == 'true') ? true: false;
                break;
            case 'cy': // Currency
            case 'error': // Error Status Code
            case 'vector': // Vector
            case 'array': // Array
            case 'blob': // Binary Blob
            case 'oblob': // Binary Blob Object
            case 'stream': // Binary Stream
            case 'ostream': // Binary Stream Object
            case 'storage': // Binary Storage
            case 'ostorage': // Binary Storage Object
            case 'vstream': // Binary Versioned Stream
            case 'clsid': // Class ID
            case 'cf': // Clipboard Data
                break;
        }
        return $propertyValue;
    }

    public static function convertPropertyType($propertyType)
    {
        switch ($propertyType) {
            case 'i1': // 1-Byte Signed Integer
            case 'i2': // 2-Byte Signed Integer
            case 'i4': // 4-Byte Signed Integer
            case 'i8': // 8-Byte Signed Integer
            case 'int': // Integer
            case 'ui1': // 1-Byte Unsigned Integer
            case 'ui2': // 2-Byte Unsigned Integer
            case 'ui4': // 4-Byte Unsigned Integer
            case 'ui8': // 8-Byte Unsigned Integer
            case 'uint': // Unsigned Integer
                $propertyType = self::PROPERTY_TYPE_INTEGER;
                break;
            case 'r4': // 4-Byte Real Number
            case 'r8': // 8-Byte Real Number
            case 'decimal': // Decimal
                $propertyType = self::PROPERTY_TYPE_FLOAT;
                break;
            case 'empty': // Empty
            case 'null': // Null
            case 'lpstr': // LPSTR
            case 'lpwstr': // LPWSTR
            case 'bstr': // Basic String
                $propertyType = self::PROPERTY_TYPE_STRING;
                break;
            case 'date': // Date and Time
            case 'filetime': // File Time
                $propertyType = self::PROPERTY_TYPE_DATE;
                break;
            case 'bool': // Boolean
                $propertyType = self::PROPERTY_TYPE_BOOLEAN;
                break;
            case 'cy': // Currency
            case 'error': // Error Status Code
            case 'vector': // Vector
            case 'array': // Array
            case 'blob': // Binary Blob
            case 'oblob': // Binary Blob Object
            case 'stream': // Binary Stream
            case 'ostream': // Binary Stream Object
            case 'storage': // Binary Storage
            case 'ostorage': // Binary Storage Object
            case 'vstream': // Binary Versioned Stream
            case 'clsid': // Class ID
            case 'cf': // Clipboard Data
                $propertyType = self::PROPERTY_TYPE_UNKNOWN;
                break;
            default:
                $propertyType = self::PROPERTY_TYPE_UNKNOWN;
        }
        return $propertyType;
    }
}
