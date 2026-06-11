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

namespace PhpOffice\PhpProject\Writer;

use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\Shared\XMLWriter;

/**
 * GnomePlanner writer
 */
class GnomePlanner implements WriterInterface
{
    /**
     * PHPProject object
     *
     * @var \PhpOffice\PhpProject\PhpProject
     */
    private $phpProject;

    /**
     * Create a new GnomePlanner writer
     *
     * @param PhpProject $phpProject
     */
    public function __construct(PhpProject $phpProject)
    {
        $this->phpProject = $phpProject;
    }

    /**
     * @param string $pFilename
     * @throws \Exception
     */
    public function save(string $pFilename): void
    {
        // Create XML Object
        $oXML = new XMLWriter(XMLWriter::STORAGE_DISK);
        $oXML->startDocument('1.0', 'UTF-8');

        // project
        $oXML->startElement('project');
        $oXML->writeAttribute('mrproject-version', '2');

        // resources
        $oXML->startElement('resources');
        foreach ($this->phpProject->getAllResources() as $oResource) {
            $this->writeResource($oXML, $oResource);
        }
        $oXML->endElement();

        // >project
        $oXML->endElement();

        // Writing XML Object in file
        if (file_exists($pFilename) && !is_writable($pFilename)) {
            throw new \Exception("Could not open file $pFilename for writing.");
        }
        $fileHandle = fopen($pFilename, 'wb+');
        fwrite($fileHandle, $oXML->getData());
        fclose($fileHandle);
    }

    /**
     * @param XMLWriter $oXML
     * @param \PhpOffice\PhpProject\Resource $oResource
     */
    private function writeResource(XMLWriter $oXML, \PhpOffice\PhpProject\Resource $oResource): void
    {
        $oXML->startElement('resource');
        $oXML->writeAttribute('id', $oResource->getIndex());
        $oXML->writeAttribute('name', $oResource->getTitle());
        $oXML->endElement();
    }

}
