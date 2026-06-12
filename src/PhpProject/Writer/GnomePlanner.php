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
use PhpOffice\PhpProject\Resource;
use PhpOffice\PhpProject\Shared\XMLWriter;
use PhpOffice\PhpProject\Task;

/**
 * GnomePlanner writer
 */
class GnomePlanner implements WriterInterface
{
    /**
     * PHPProject object
     *
     * @var PhpProject
     */
    protected $phpProject;

    /**
     *
     * @var array<array{id_res: int, id_task: int}>
     */
    protected $arrAllocations;

    /**
     * Create a new GnomePlanner writer
     *
     * @param PhpProject $phpProject
     */
    public function __construct(PhpProject $phpProject)
    {
        $this->phpProject = $phpProject;
        $this->arrAllocations = array();
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

        // project
        $xml->startElement('project');
        $xml->writeAttribute('mrproject-version', '2');

        // tasks
        $xml->startElement('tasks');
        foreach ($this->phpProject->getAllTasks() as $task) {
            $this->writeTask($xml, $task);
        }
        $xml->endElement();

        // resources
        $xml->startElement('resources');
        foreach ($this->phpProject->getAllResources() as $resource) {
            $this->writeResource($xml, $resource);
        }
        $xml->endElement();

        // allocations
        $xml->startElement('allocations');
        if (count($this->arrAllocations) > 0) {
            foreach ($this->arrAllocations as $allocation) {
                $this->writeAllocation($xml, $allocation['id_task'], $allocation['id_res']);
            }
        }
        $xml->endElement();

        // >project
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
        $xml->startElement('resource');
        $xml->writeAttribute('id', $resource->getIndex());
        $xml->writeAttribute('name', $resource->getTitle());
        $xml->endElement();
    }

    /**
     * @param XMLWriter $xml
     * @param Task $task
     */
    protected function writeTask(XMLWriter $xml, Task $task): void
    {
        $xml->startElement('task');
        $xml->writeAttribute('id', $task->getIndex());
        $xml->writeAttribute('name', $task->getName());
        if ($task->getStartDate() !== null) {
            $xml->writeAttribute('start', date('Ymd\THis\Z', $task->getStartDate()));
        }
        if ($task->getEndDate() !== null) {
            $xml->writeAttribute('end', date('Ymd\THis\Z', $task->getEndDate()));
        }
        if ($task->getDuration() !== null) {
            $xml->writeAttribute('work', $task->getDuration());
        }
        $xml->writeAttribute('percent-complete', (int) (($task->getProgress() ?? 0) * 100));

        // Resources Allocations
        if ($task->getResourceCount() > 0) {
            foreach ($task->getResources() as $resource) {
                $allocation = array();
                $allocation['id_res'] = $resource->getIndex();
                $allocation['id_task'] = $task->getIndex();
                $this->arrAllocations[] = $allocation;
            }
        }

        // Children (recursive)
        foreach ($task->getTasks() as $taskChild) {
            $this->writeTask($xml, $taskChild);
        }

        $xml->endElement();
    }

    /**
     * Write allocation of a resource for a task
     * @param XMLWriter $xml
     * @param int $idTask
     * @param int $idResource
     */
    protected function writeAllocation(XMLWriter $xml, int $idTask, int $idResource): void
    {
        $xml->startElement('allocation');
        $xml->writeAttribute('task-id', $idTask);
        $xml->writeAttribute('resource-id', $idResource);
        $xml->writeAttribute('units', '100');
        $xml->endElement();
    }
}
