<?php

/**
 * This file is part of PHPProject - A pure PHP library for reading and writing
 * project management files.
 *
 * PHPProject is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPProject/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPProject
 * @copyright   2009-2014 PHPProject contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

declare(strict_types=1);

namespace PhpOffice\PhpProject\Writer;

use PhpOffice\PhpProject\PhpProject;
use PhpOffice\PhpProject\Resource;
use PhpOffice\PhpProject\Shared\XMLWriter;
use PhpOffice\PhpProject\Task;

/**
 * MSPDI (Microsoft Project Data Interchange) writer
 */
class MSPDI implements WriterInterface
{
    /**
     * PHPProject object
     *
     * @var PhpProject
     */
    protected $phpProject;

    /**
     * Create a new MSPDI writer
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
        $xml = new XMLWriter(XMLWriter::STORAGE_DISK);
        $xml->startDocument('1.0', 'UTF-8');

        // Project
        $xml->startElement('Project');
        $xml->writeAttribute('xmlns', 'http://schemas.microsoft.com/project');

        // Tasks
        $xml->startElement('Tasks');
        foreach ($this->phpProject->getAllTasks() as $task) {
            $this->writeTask($xml, $task);
        }
        $xml->endElement();

        // Resources
        $xml->startElement('Resources');
        foreach ($this->phpProject->getAllResources() as $resource) {
            $this->writeResource($xml, $resource);
        }
        $xml->endElement();

        // >Project
        $xml->endElement();

        // Writing XML Object in file
        if (file_exists($pFilename) && !is_writable($pFilename)) {
            throw new \Exception("Could not open file $pFilename for writing.");
        }
        $fileHandle = fopen($pFilename, 'wb+');
        fwrite($fileHandle, $xml->getData());
        fclose($fileHandle);
    }

    /**
     * @param XMLWriter $xml
     * @param Resource $resource
     */
    protected function writeResource(XMLWriter $xml, Resource $resource): void
    {
        $xml->startElement('Resource');
        $xml->writeElement('UID', (string) $resource->getIndex());
        $xml->writeElement('Name', $resource->getTitle());
        $xml->endElement();
    }

    /**
     * @param XMLWriter $xml
     * @param Task $task
     */
    protected function writeTask(XMLWriter $xml, Task $task): void
    {
        $xml->startElement('Task');
        $xml->writeElement('UID', (string) $task->getIndex());
        $xml->writeElement('Name', $task->getName());
        if ($task->getStartDate() !== null) {
            $xml->writeElement('Start', date('Y-m-d\TH:i:s', $task->getStartDate()));
        }
        if ($task->getEndDate() !== null) {
            $xml->writeElement('Finish', date('Y-m-d\TH:i:s', $task->getEndDate()));
        }
        if ($task->getDuration() !== null) {
            $xml->writeElement('Work', (string) $task->getDuration());
        }
        $xml->writeElement('PercentComplete', (string) (int) (($task->getProgress() ?? 0) * 100));
        $xml->endElement();
    }
}
