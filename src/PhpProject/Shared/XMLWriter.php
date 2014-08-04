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

namespace PhpOffice\PhpProject\Shared;


/**
 * PHPProject_Shared_XMLWriter
 *
 * @category   PHPProject
 * @package    PHPProject_Shared
 * @copyright  Copyright (c) 2012 - 2012 PHPProject (https://github.com/PHPOffice/PHPProject)
 */
class XMLWriter extends \XMLWriter
{
    /** Temporary storage method */
    const STORAGE_MEMORY    = 1;
    const STORAGE_DISK      = 2;
    
    const DATE_W3C = 'Y-m-d\TH:i:sP';
    const DEBUGMODE_ENABLED = false;

    /**
     * Temporary filename
     *
     * @var string
     */
    private $_tempFileName = '';

    /**
     * Create a new PHPProject_Shared_XMLWriter instance
     *
     * @param int        $pTemporaryStorage            Temporary storage location
     * @param string    $pTemporaryStorageFolder    Temporary storage folder
     */
    public function __construct($pTemporaryStorage = self::STORAGE_MEMORY, $pTemporaryStorageFolder = null)
    {
        // Open temporary storage
        if ($pTemporaryStorage == self::STORAGE_MEMORY) {
            $this->openMemory();
        } else {
            // Create temporary filename
            if ($pTemporaryStorageFolder === null) {
                $pTemporaryStorageFolder = File::sysGetTempDir();
            }
            $this->_tempFileName = @tempnam($pTemporaryStorageFolder, 'xml');

            // Open storage
            if ($this->openUri($this->_tempFileName) === false) {
                // Fallback to memory...
                $this->openMemory();
            }
        }

        // Set default values
        if (self::DEBUGMODE_ENABLED) {
            $this->setIndent(true);
        }
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        // Unlink temporary files
        if ($this->_tempFileName != '') {
            @unlink($this->_tempFileName);
        }
    }

    /**
     * Get written data
     *
     * @return $data
     */
    public function getData()
    {
        if ($this->_tempFileName == '') {
            return $this->outputMemory(true);
        } else {
            $this->flush();
            return file_get_contents($this->_tempFileName);
        }
    }

    /**
     * Fallback method for writeRaw, introduced in PHP 5.2
     *
     * @param string $text
     * @return string
     */
    public function writeRawData($text)
    {
        if (is_array($text)) {
            $text = implode("\n", $text);
        }

        if (method_exists($this, 'writeRaw')) {
            return $this->writeRaw(htmlspecialchars($text));
        }

        return $this->text($text);
    }
}
